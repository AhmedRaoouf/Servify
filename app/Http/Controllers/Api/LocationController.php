<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Http\Resources\GovernorateResource;
use App\Models\Country;
use App\Services\Service;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCountries()
    {
        $countries = Country::get();
        return Service::responseData(CountryResource::collection($countries), 'countries');
    }

    public function getGovernorates(Country $country)
    {
        if ($country) {
            return Service::responseData(new GovernorateResource($country), 'governorate');
        } else {
            return Service::responseError('Country not found', 404);
        }

    }
}
