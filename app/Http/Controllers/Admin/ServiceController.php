<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Models\ServiceDescription;
use App\Services\Service as Helper;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['services'] = Service::get();
        return view("dashboard.services.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.services.index");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        $imageName = Helper::uploadImage($request->image, "services/");
        $service = Service::create([
            "image" => $imageName,
        ]);
        ServiceDescription::create([
            "service_id" => $service->id,
            "language_id" => 1,
            "name" => $request->name_en,
            "description" => $request->description_en,
        ]);
        ServiceDescription::create([
            "service_id" => $service->id,
            "language_id" => 2,
            "name" => $request->name_ar,
            "description" => $request->description_ar,
        ]);

        return redirect(url('dashboard/services'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view("dashboard.services.index", get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $imageName = Helper::uploadImage($request->image, 'services/');
        $serviceDescription = ServiceDescription::where('service_id',$service->id)->get();
        $service->update([
            'image' => $imageName ?? $service->image,
            'status' => $request->status,
            'updated_at' => now(),
        ]);
        $serviceDescription[0]->update([
            'name'=>$request->name_en,
            'description'=>$request->description_en,
        ]);
        $serviceDescription[1]->update([
            'name'=>$request->name_ar,
            'description'=>$request->description_ar,
        ]);
        return redirect(url('dashboard/services'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect(route('services.index'));
    }
}
