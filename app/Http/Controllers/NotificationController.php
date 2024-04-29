<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AppointmentCreated;
use App\Notifications\AppointmentUpdated; // Import Notification facade
 // Import Notification facade
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function sendNotification(Request $request, $receiverId)
{
    try {
        // Find the receiver user
        $receiver = User::findOrFail($receiverId);
        
        // Get appointment data from the request
        $appointmentData = $request->all(); // Adjust this based on how appointment data is passed in your request
        
        // Send a notification to the receiver
        $receiver->notify(new AppointmentCreated($appointmentData)); // Assuming you have a notification class named AppointmentCreated

        return response()->json(['message' => 'Notification sent successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to send notification', 'message' => $e->getMessage()], 500);
    }
}


public function getNotifications($userId)
{
    try {
        // Find the user
        $user = User::findOrFail($userId);
        
        // Fetch all notifications for the user
        $notifications = $user->notifications()->get();
        
        // Mark notifications as read
        $user->unreadNotifications()->update(['read_at' => now()]);
        
        return response()->json(['notifications' => $notifications], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to fetch notifications', 'message' => $e->getMessage()], 500);
    }
}

public function markNotificationsAsRead(Request $request, $userId)
    {
        try {
            // Find the user
            $user = User::findOrFail($userId);
            
            // Mark notifications as read
            $user->unreadNotifications()->update(['read_at' => now()]);
            
            return response()->json(['message' => 'Notifications marked as read successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to mark notifications as read', 'message' => $e->getMessage()], 500);
        }
    }

    public function sendAppointmentUpdatedNotification($userId, $appointmentData)
    {
        try {
            // Find the receiver user
            $receiver = User::findOrFail($userId);
            
            // Send a notification to the receiver
            $receiver->notify(new AppointmentUpdated($appointmentData));

            return true;
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            return false;
        }
    }

// public function getNotifications($userId)
// {
//     try {
//         // Find the user
//         $user = User::findOrFail($userId);
        
//         // Fetch the user's notifications where the notifiable_id matches the user_id
//         $notifications = $user->unreadNotifications()->where('notifiable_id', $userId)->get();
        
//         // Mark notifications as read
//         $user->unreadNotifications()->where('notifiable_id', $userId)->update(['read_at' => now()]);
        
//         return response()->json(['notifications' => $notifications], 200);
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Failed to fetch notifications', 'message' => $e->getMessage()], 500);
//     }
// }


}