<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentUpdated extends Notification
{
    use Queueable;

    protected $appointmentData;

    /**
     * Create a new notification instance.
     *
     * @param array $appointmentData
     * @return void
     */
    public function __construct(array $appointmentData)
    {
        $this->appointmentData = $appointmentData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'service_detail_name' => $this->appointmentData['service_detail_name'] ?? null,
            'appointment_id' => $this->appointmentData['appointment_id'] ?? null,
            'message' => $this->appointmentData['message'] ?? 'Your appointment has been updated.',
            'created_by' => $this->appointmentData['created_by'] ?? null,
            'updated_by' => $this->appointmentData['updated_by'] ?? null,
            // Add any other data you need from the appointment data array
        ];
    }
}