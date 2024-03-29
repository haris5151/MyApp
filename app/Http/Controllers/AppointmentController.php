<?php

namespace App\Http\Controllers;

use App\Models\CdAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createAppointment(Request $request)
    {
        $validator = validator::make($request->all(), [
            'service_id' => ['required', 'exists:users,id'],
            'customer_id' => ['required', 'exists:users,id'],

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = Auth::user();
        if ($user->hasRole('customer')) {
            $customerId = $user->id;
            $serviceId = $request->input('service_id');
        } elseif ($user->hasRole('service_provider')) {
            $customerId = $request->input('customer_id');
            $serviceId = $user->id;
        } else {
            return response()->json(['error' => 'User does not have a valid role'], 403);
        }
        $appointment = new CdAppointment();
        $appointment->customer_id = $customerId;
        $appointment->service_id = $serviceId;
        $appointment->description=$request->input('description');
        $appointment->status=$request->input('status');

        $appointment->appointment_date = $request->input('appointment_date');
        $appointment->appointment_time =$request->input('appointment_time');

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
    public function update(Request $request, string $id)
    {
        $appointment = CdAppointment::findOrFail($id);
    
        $validator = validator::make($request->all(), [
            'service_id' => ['required', 'exists:uers,id'],
            'customer_id' => ['required', 'exists:uers,id'],

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Determine the role of the user
        $user = Auth::user();
        if ($user->hasRole('customer')) {
            // Ensure the customer can only update their own appointments
            if ($appointment->customer_id !== $user->id) {
                return response()->json(['error' => 'You are not authorized to update this appointment'], 403);
            }
            $customerId = $user->id;
            $serviceId = $request->input('service_id'); // You can retrieve service_id from the request or any other source
        } elseif ($user->hasRole('service_provider')) {
            // Ensure the service provider can only update appointments they are providing
            if ($appointment->service_id !== $user->id) {
                return response()->json(['error' => 'You are not authorized to update this appointment'], 403);
            }
            $customerId = $request->input('customer_id'); // You can retrieve customer_id from the request or any other source
            $serviceId = $user->id;
        } else {
            return response()->json(['error' => 'User does not have a valid role'], 403);
        }
    

        $appointment->customer_id = $customerId;
        $appointment->service_id = $serviceId;
        $appointment->appointment_date = $request->input('appointment_date');
        $appointment->appointment_time = $request->input('appointment_time');
        
        $appointment->save();
    
        return response()->json(['message' => 'Appointment updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
