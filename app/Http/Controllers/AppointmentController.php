<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('appointment.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new-appointment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'title' => 'required|unique:appointments|max:255',
            'description' => 'required',
            'datetime' => 'required | date',
            'notification_date' => 'required | in:10,30,60,1440'
        ]);

        // Additional date validation
        $appointmentDate = New Carbon($request->datetime);
        $now = (New Carbon())->nowWithSameTz();

        if ($appointmentDate < $now) {

            return back()->withInput()->withErrors('Appointment must be set to a future date');

        }

        // Store in DB
        try {

            $notificationDate = $appointmentDate->subMinutes($request->notification_date);

            Appointment::create([
                'title' => $request->title,
                'description' => $request->description,
                'appointment_date' => $request->datetime,
                'notification_date' => $notificationDate,
                'user_id' => Auth()->user()->id
            ]);

            return redirect()->route('home')->with('status', 'Appointment created');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::find($id);

        if (!empty($appointment)) {
            // Date to minutes
            $appointmentDate = new Carbon($appointment->appointment_date);
            $notificationDate = new Carbon($appointment->notification_date);

            $diff = $appointmentDate->diffInMinutes($notificationDate);

            switch ($diff) {

                case 10:
                    $appointment->notification_date = '10 min before';
                    break;
                case 30:
                    $appointment->notification_date = '30 min before';
                    break;
                case 1440:
                    $appointment->notification_date = '1 day before';
                    break;
                default:
                    $appointment->notification_date = '';
                    break;
            }
        }

        return view('show-appointment', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $appointment = Appointment::find($id);

        return view('edit-appointment', compact('appointment'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'title' => [
                'required',
                Rule::unique('appointments')->ignore($id),
                'max:255',
                ],
            'description' => 'required',
            'datetime' => 'required | date',
            'notification_date' => 'required | in:10,30,60,1440'
        ]);

        // Additional date validation
        $appointmentDate = New Carbon($request->datetime);
        $now = (New Carbon())->nowWithSameTz();

        if ($appointmentDate < $now) {

            return back()->withInput()->withErrors('Appointment must be set to a future date');

        }

        // Update DB
        try {

            $notificationDate = $appointmentDate->subMinutes($request->notification_date);

            $appointment = Appointment::find($id);

            $appointment->title = $request->title;
            $appointment->description = $request->description;
            $appointment->appointment_date = $request->datetime;
            $appointment->notification_date = $notificationDate;

            $appointment->save();

            return redirect()->route('home')->with('status', 'Appointment updated');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            Appointment::destroy($id);

            return redirect()->route('home')->with('status', 'Appointment deleted');

        } catch (\Exception $e) {

            return back()->withInput()->withErrors($e->getMessage());
        }
    }
}
