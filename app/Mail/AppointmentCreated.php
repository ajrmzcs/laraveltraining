<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;


    /**
     * AppointmentCreated constructor.
     * @param Appointment $appointment
     */
    public function __construct(Appointment $appointment)
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
        if($this->appointment->wasRecentlyCreated){
            return $this->markdown('emails.new-appointment')->subject('You have a new appointment');
        } else {
            return $this->markdown('emails.appointment-notification')->subject('Remember your appointment');
        }
    }
}
