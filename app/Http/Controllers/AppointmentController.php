<?php

namespace App\Http\Controllers;

use App\Models\CdAppointment;
use App\Notifications\AppointmentCreated;
use App\Notifications\AppointmentUpdated;
use App\Models\User;
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
        $appointments = CdAppointment::with('service', 'user')->get();
        return response()->json($appointments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'service_detail_id' => ['required', 'array', 'min:1'], // Ensure array with at least one ID
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required'],
            // 'description' => ['nullable'], // Optional description
            'status' => ['nullable', 'in:pending,cancel,approved'], // Optional status with validation
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $serviceDetailIds = $request->input('service_detail_id');
        $createdAppointments = [];

        foreach ($serviceDetailIds as $serviceDetailId) {
            try {
                // Validate and fetch service details (replace with proper logic)
                $serviceDetails = MdServiceDetail::findOrFail($serviceDetailId);

                // Extract other required fields from the request (assuming they're not in the array)
                $userId = $request->input('user_id');
                $appointmentDate = $request->input('appointment_date');
                $appointmentTime = $request->input('appointment_time');
                $description = $request->input('description'); // Optional
                $status = $request->input('status'); // Optional

                $appointment = new CdAppointment();
                $appointment->user_id = $userId;
                $appointment->receiver_id = $serviceDetails->created_by; // Assuming receiver_id comes from service details
                $appointment->service_detail_id = $serviceDetailId;
                $appointment->description = $description;
                $appointment->status = $status;
                $appointment->appointment_date = $appointmentDate;
                $appointment->appointment_time = $appointmentTime;
                $appointment->created_by = $request->input('created_by');
                $appointment->updated_by = $request->input('updated_by');

                $appointment->save();

                
                $notificationData = [
                    'service_detail_name' => $serviceDetails->service_name, // Assuming the service detail has a 'name' attribute
                    'appointment_id' => $appointment->id,
                    'message' => 'New Order has been created.',
                    'created_by' => $request->input('created_by'),
                    'updated_by' => $request->input('updated_by'),
                    // Add any other data you need for the notification
                ];
        
                // Notify the receiver about the appointment
                $receiver = User::find($serviceDetails->created_by); // Fetch receiver user by created_by from service details
                if ($receiver) {
                    $receiver->notify(new AppointmentCreated($notificationData)); 
                }
                
                $createdAppointments[] = $appointment;

            } catch (\Exception $e) {
                // Handle potential exceptions during individual appointment creation
                // Log the error or return a specific error response for the failing ID
                return response()->json(['error' => "Error creating appointment for service detail ID: $serviceDetailId", 'exception' => $e->getMessage()], 500);
            }
        }

        return response()->json([

            'message' => 'Appointments created successfully',
            'appointments' => $createdAppointments,

        ], 201);
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
        $appointment->appointment_time = $request->input('appointment_time');
        $appointment->appointment_date = $request->input('appointment_date');
        $appointment->save();


        $createdByUserId = $appointment->created_by;
        $creator = User::find($createdByUserId);
    
        if ($creator) {
            // Prepare notification data
            $notificationData = [
                'appointment_id' => $appointment->id,
                'message' => 'Your appointment has been updated.',
                // Add any other data you need for the notification
            ];
    
            // Send the notification
            $creator->notify(new AppointmentUpdated($notificationData));
        }

        // Return the updated appointment
        return response()->json(['appointment' => $appointment], 200);

        $appointment->save();
    }
    // public function getservicedetails($service_detail_id)
    // {
    //     // Retrieve service details along with related appointments using eager loading
    //     $serviceDetails = MdServiceDetail::with('appointments')->get($service_detail_id);

    //     return response()->json(['service_details' => $serviceDetails]);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}


// $pusherBeams = new \Pusher\Pusher(

                //     env('PUSHER_BEAMS_INSTANCE_ID'),
                //     env('PUSHER_BEAMS_SECRET_KEY'),
                //     env('PUSHER_BEAMS_APP_ID'),

                //     [

                //         'cluster' => env('PUSHER_BEAMS_CLUSTER'),
                //         'useTLS' => true,

                //     ]

                // );

                // $chatRoomId = $pusherBeams->post('/chatkit/v1/rooms', [

                //     'name' => "Appointment Chat - {$appointment->id}",
                //     'user_ids' => [$appointment->user_id, $appointment->receiver_id],

                // ]);

                // // Store the chat room ID in the appointment model

                // $appointment->chat_room_id = $chatRoomId;
                // $appointment->save();
