<?php

namespace App\Http\Controllers;

use App\Models\CdAppointment;
use App\Models\MdServiceDetail;
use function Pest\Laravel\get;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointment = CdAppointment::all();
        return response()->json($appointment);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'service_detail_id' => ['required', 'exists:md_service_details,id'], // Ensure the 'service_detail_id' parameter exists in the request and is valid
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Extract the service detail ID from the request
        $serviceDetailId = $request->input('service_detail_id');

        // Fetch the service details based on the provided service detail ID
        $serviceDetails = MdServiceDetail::findOrFail($serviceDetailId);

        // Extract the receiver_id (created_by) from the service details
        $receiverId = $serviceDetails->created_by;

        $appointment = new CdAppointment();
        $appointment->user_id = $request->input('user_id');
        $appointment->receiver_id = $receiverId;
        $appointment->service_detail_id = $serviceDetailId;
        $appointment->description = $request->input('description');
        $appointment->status = $request->input('status');
        $appointment->appointment_date = $request->input('appointment_date');
        $appointment->appointment_time = $request->input('appointment_time');

        $appointment->save();

        return response()->json(['message' => 'Appointment created successfully'], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Retrieve the appointment
        $appointment = CdAppointment::find($id);

        // Check if the appointment exists
        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        // Check if the authenticated user is the receiver of the appointment
        // $user = Auth::user();
        // if ($user->id !== $appointment->receiver_id) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'in:pending,cancel,approved'], // Ensure status field is provided and contains a valid value
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update the appointment status
        $appointment->status = $request->input('status');
        $appointment->save();

        // Return success response
        return response()->json(['message' => 'Appointment updated successfully'], 200);
    }
    public function getservicedetails($service_detail_id)
    {
        // Retrieve service details along with related appointments using eager loading
        $serviceDetails = MdServiceDetail::with('appointments')->get($service_detail_id);

        return response()->json(['service_details' => $serviceDetails]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
