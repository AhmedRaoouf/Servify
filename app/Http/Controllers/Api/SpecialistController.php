<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialistRequest;
use App\Http\Resources\RatingResource;
use App\Http\Resources\SpecialistResource;
use App\Models\Specialist;
use App\Models\SpecialistReview;
use App\Models\UserAuthentication;
use App\Services\Service as helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecialistRequest $request)
    {
        $personal_card = [];
        foreach ($request->personal_card as $image) {
            $personal_card[] = Helper::uploadImage($image, "services/");
        }
        $token = $request->header('Authorization');
        $userAuth = UserAuthentication::where('token', $token)->first();
        $personal_image = Helper::uploadImage($request->personal_image, "services/");
        $specialist = Specialist::create([
            "user_id" => $userAuth->user_id,
            "service_id" => $request->service_id,
            "description" => $request->description,
            "num_of_experience" =>  $request->num_of_experience,
            "personal_card" => json_encode($personal_card),
            "personal_image" => $personal_image,
        ]);
        return  helper::responseData(new SpecialistResource($specialist), 'Specialist Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $specialist = Specialist::where('service_id', $id)->first();
        if ($specialist) {
            return helper::responseData(new SpecialistResource($specialist), 'Specialist');
        } else {
            return helper::responseError("Specialist Not Found", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialist  $specialist)
    {
        $validator = Validator::make($request->all(),[
            'description' => 'required|string|max:1500',
        ]);
        if ($validator->fails()) {
            return helper::responseError($validator->errors()->all(),422);
        }
        $specialist = $specialist->update([
            'description'=>$request->description
        ]);
        return helper::responseData(new SpecialistResource($specialist), 'Specialist Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    public function rating(Request $request, $specialist_id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric',
            'review' => 'required|text',
        ]);

        if ($validator->fails()) {
            return helper::responseError($validator->errors()->all(), 422);
        }
        $token = $request->header('Authorization');
        $userAuth = UserAuthentication::where('token', $token)->first();
        $rating = SpecialistReview::create([
            'user_id' =>  $userAuth->user_id,
            'specialist_id' => $specialist_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return helper::responseData(new RatingResource($rating), 'Specialist Rating');
    }
}
