<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $appointment;

    /**
     * Create a new message instance.
     *
     * @param $appointment
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Created')
                    ->html($this->buildHtmlContent());
    }

    /**
     * Build HTML content for the email.
     *
     * @return string
     */
    protected function buildHtmlContent()
    {
        // Customize the HTML content based on your needs
        $appointment = $this->appointment;

        $htmlContent = "<p>Hello,</p>";
        $htmlContent .= "<p>An appointment has been created:</p>";
        $htmlContent .= "<p>Appointment Date: {$appointment->appointment_date}</p>";
        $htmlContent .= "<p>Appointment Time: {$appointment->appointment_time}</p>";
        $htmlContent .= "<p>Description: {$appointment->description}</p>";
        // Add more appointment details as needed

        return $htmlContent;
    }
}
