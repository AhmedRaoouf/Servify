<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\Service;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource with pagination (6 per page).
     */
    public function index()
    {
        $bookings = Booking::paginate(6);

        if ($bookings->isEmpty()) {
            return Service::responseMsg('No bookings available.');
        }

        return Service::responseData(BookingResource::collection($bookings), 'Bookings retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request) // Type-hint BookingRequest
    {
        $newBooking = Booking::create($request->validated());
        return Service::responseData(new BookingResource($newBooking), 'New booking added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        dd($booking);
        if ($booking->isEmpty()) {
            return Service::responseError("Booking not found", 404);
        }

        return Service::responseData(new BookingResource($booking), 'Booking');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingRequest $request, Booking $booking)
    {
        $booking->update($request->validated());
        return Service::responseData(new BookingResource($booking), 'Booking updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return Service::responseError('Booking not found', 404);
        }

        $booking->delete();
        return Service::responseMsg('Booking deleted successfully');
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
