<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialistRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\RatingResource;
use App\Http\Resources\SpecialistResource;
use App\Models\Order;
use App\Models\Specialist;
use App\Models\SpecialistReview;
use App\Models\User;
use App\Models\UserAuthentication;
use App\Services\Service as helper;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class SpecialistController extends Controller
{
    public function index(Request $request){
        $token = $request->header('Authorization');
        $userAuth = UserAuthentication::where('token', $token)->first();
        $specialist = Specialist::where('user_id', $userAuth->user_id)->first();
        if (!$specialist) {
            return response()->json(['error' => 'Specialist not found'], 404);
        }
        $requests = Order::where('specialist_id', $specialist->id)
            ->where('status', 'pending')
            ->get();

        return helper::responseData(OrderResource::collection($requests), 'Specialist Requests');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecialistRequest $request)
    {
        $token = $request->header('Authorization');
        $userAuth = UserAuthentication::where('token', $token)->first();
        $personalCardFiles = [];
        if ($request->hasFile('personal_card')) {
            $personalCardFiles = array_map(function ($image) {
                return Helper::uploadImage($image, "specialists/");
            }, Arr::wrap($request->file('personal_card')));
        }
        $specialist = Specialist::create([
            "user_id" => $userAuth->user_id,
            "service_id" => $request->service_id,
            "description" => $request->description,
            "num_of_experience" =>  $request->num_of_experience,
            "personal_card" => json_encode($personalCardFiles),
            "personal_image" => Helper::uploadImage($request->personal_image, "services/"),
        ]);
        User::where('id', $userAuth->user_id)->update(['is_specialist' => 1]);
        return  helper::responseData(new SpecialistResource($specialist), 'Specialist Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialist $specialist)
    {
        if ($specialist) {
            return helper::responseData(new SpecialistResource($specialist), 'Specialist');
        } else {
            return helper::responseError("Specialist Not Found", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialist $specialist)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return helper::responseError($validator->errors()->all(), 422);
        }
        $specialist->update(['description' => $request->description]);
        return helper::responseData(new SpecialistResource($specialist), 'Specialist Updated Successfully');
    }


    public function rating(Request $request, Specialist $specialist)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string',
        ]);

        if ($validator->fails()) {
            return helper::responseError($validator->errors()->all(), 422);
        }
        if (!$specialist) {
            return helper::responseError('Specialist not found', 404);
        }
        $token = $request->header('Authorization');
        $userAuth = UserAuthentication::where('token', $token)->first();
        $rating = SpecialistReview::create([
            'user_id' =>  $userAuth->user_id,
            'specialist_id' => $specialist->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);
        $average_rate = SpecialistReview::where('specialist_id', $specialist->id)->avg('rating');
        $specialist->update(['average_rating' => round($average_rate)]);
        return helper::responseData(new RatingResource($rating), 'Specialist Rating');
    }

    public function orders()
    {
        // $token = $request->header('Authorization');
        // $userAuth = UserAuthentication::where('token', $token)->first();
        // $specialist = Specialist::where('user_id', $userAuth->user_id)->first();
        // if (!$specialist) {
        //     return response()->json(['error' => 'Specialist not found'], 404);
        // }
        // $requests = Order::where('specialist_id', $specialist->id)
        //     ->where('status', 'pending')
        //     ->get();

        // return helper::responseData(OrderResource::collection($requests), 'Specialist Requests');
    }


    public function acceptOrder(Order $order)
    {
        if ($order) {
            $order->update(['status' => 'accept']);
        }else {
            return helper::responseError('Order Not Found',404);
        }
        return helper::responseMsg('Order Accepted Successfully');
    }

    public function cancelOrder(Order $order)
    {
        if ($order) {
            $order->update(['status' => 'cancel']);
        }else {
            return helper::responseError('Order Not Found',404);
        }
        return helper::responseMsg('Order Canceled Successfully');
    }
}
