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

class ServiceController extends Controller
{

    public function index()
    {
        $services = Service::all();
        return helper::responseData(ServiceResource::collection($services), 'Services');
    }

    public function showAll($service)
    {
        $serviceDescription = ServiceDescription::where('name', $service)->first();
        if ($serviceDescription) {
            $serviceId = $serviceDescription->service_id;
            $specialists = Specialist::where('service_id', $serviceId)->get();
            return helper::responseData(SpecialistCardResource::collection($specialists), 'Specialist');
        }else{
            return helper::responseError("Service Not Found" ,404);
        }
    }
}
