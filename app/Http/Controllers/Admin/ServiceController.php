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
        $data["services"] = ServiceDescription::get();
        return view("dashboard.services.index", $data );
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
        $service = Service::create([]);
        ServiceDescription::create(array_merge($request->validated(), [
            "image" => $imageName,
            "service_id" => $service->id,
        ]));

        return redirect(url('dashboard/services'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceDescription $service)
    {
        return view("dashboard.services.index",get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, ServiceDescription $service)
    {
        $imageName = Helper::uploadImage($request->image,'services');
        $service->update(array_merge($request->validated(),[
            'image' => $imageName ?? $service->image,
        ]));
        $service->service->update([
            'status'=>$request->status,
            'updated_at' => now(),
        ]);

        return redirect(url('dashboard/services'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
