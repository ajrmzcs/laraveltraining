<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function showAppointments()
    {

        $appointments = Appointment::all();

        $events = [];

        if (!empty($appointments)) {
            foreach($appointments as $appointment) {
                array_push($events,[
                    'id' => $appointment->id,
                    'title' => $appointment->title,
                    'start' => $appointment->appointment_date,
                    'end' => (new Carbon($appointment->appointment_date))->addHour(1),
                    'allDay' => false,
                    'url' => route('appointment.show', [$appointment->id]),
                ]);
            }
        }

        return response()->json($events);
    }
}
