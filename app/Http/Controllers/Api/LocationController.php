<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Country;
use App\Services\Service;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function show(Country $country)
    {
        if ($country) {
            return Service::responseData(new LocationResource($country), 'governorate');
        } else {
            return Service::responseError('Country not found', 404);
        }

    }
}
