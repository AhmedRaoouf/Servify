<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SpecialistCardResource;
use App\Models\Service;
use App\Models\ServiceDescription;
use App\Models\Specialist;
use App\Services\Service as helper;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class ServiceController extends Controller
{

    public function index()
    {
        $services = Service::all();
        return helper::responseData(ServiceResource::collection($services), 'Services');
    }

    public function fetchBestSpecialists()
    {
        $bestSpecialists = Specialist::orderByDesc('average_rating')
            ->limit(6)
            ->get();
        return helper::responseData(SpecialistCardResource::collection($bestSpecialists), 'Best Specialists');
    }


    public function filterSpecialists(Request $request)
    {
        $query = Specialist::query();

        // Filter by Service
        if ($request->has('service')) {
            $service = $request->input('service');
            $descriptions = ServiceDescription::where('name', 'like', '%' . $service . '%')->get();
            $serviceIds = $descriptions->pluck('service_id')->toArray();
            $query->whereIn('service_id', $serviceIds);
        }

        // Filter by name
        if ($request->has('name')) {
            $name = $request->input('name');
            $query->whereHas('user', function (Builder $query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });
        }

        // Filter by rating
        if ($request->input('rating')) {
            $query->where('average_rating', '>=', $request->input('rating'));
        }

        $specialists = $query->get();
        if ($specialists->isEmpty()) {
            return helper::responseError("Specialists not found", 404);
        }
        return helper::responseData(SpecialistCardResource::collection($specialists), 'Fiter Specialists');
    }

    public function showAll($service)
    {
        $serviceDescription = ServiceDescription::where('name', $service)->first();
        if ($serviceDescription) {
            $serviceId = $serviceDescription->service_id;
            $specialists = Specialist::where('service_id', $serviceId)->get();
            return helper::responseData(SpecialistCardResource::collection($specialists), 'Specialist');
        } else {
            return helper::responseError("Service Not Found", 404);
        }
    }
}
