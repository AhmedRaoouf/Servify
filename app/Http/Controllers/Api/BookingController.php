<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\BookingCancel;
use App\Models\User;
use App\Notifications\BookingNotification;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource with pagination (6 per page).
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request) // Type-hint BookingRequest
    {
        $newBooking = Booking::create($request->validated());
        return Service::responseMsg("New booking added successfully");

        $specialist = User::where('id',$newBooking->user_id)->first();
        Notification::send($specialist , new BookingNotification($newBooking));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $status = $request->input('status');
        $booking = Booking::where('user_id', $id)->where('status', $status)->get();

        if ($booking->isEmpty()) {
            return Service::responseMsg("Booking not found");
        }

        return Service::responseData(BookingResource::collection($booking), 'Booking with status ' . $status);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(BookingRequest $request, Booking $booking)
    {
        $booking->update($request->validated());
        return Service::responseMsg("New booking Updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cancel(Request $request, $id)
    {
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return Service::responseError($validator->errors(), 422);
        }

        // Find the booking by ID
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Update the booking status to 'canceled'
        $booking->status = 'canceled';
        $booking->save();

        // Create a new BookingCancel entry
        $canceled = new BookingCancel();
        $canceled->booking_id = $booking->id;
        $canceled->reason = $request->input('reason');
        $canceled->description = $request->input('description');
        $canceled->save();

        return Service::responseMsg("Booking canceled successfully");
    }


    /**
     * Display a listing of bookings by status.
     */
    public function status($status)
    {
        $validStatuses = ['upcoming', 'completed', 'canceled'];
        if (!in_array($status, $validStatuses)) {
            return Service::responseError('Invalid status', 400);
        }

        $bookings = Booking::where('status', $status)->paginate(6);
        return Service::responseData(BookingResource::collection($bookings), ucfirst($status) . ' Bookings');
    }
}
