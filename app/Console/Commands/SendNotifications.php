<?php

namespace App\Console\Commands;

use App\Mail\AppointmentCreated;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotifications extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to send appointments notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d H:i') . ":00";

        $this->info('-- Sending Notifications -- at ' . $now);

        $appointments = Appointment::where('notification_date', $now)
            ->get();

        foreach ($appointments as $appointment) {

            Mail::to($appointment->user->email)->send(new AppointmentCreated($appointment));

            Log::info('-- Notification sent to: ' . $appointment->user->name . ' at ' . $appointment->notification_date);

            $this->info('  -- Notification sent to: ' . $appointment->user->name . ' at ' . $appointment->notification_date);
        }

        if (count($appointments) > 0) {
            $this->info('-- Notifications Sent -- at ' . Carbon::now()->format('Y-m-d H:i'));
        } else {
            $this->error('-- There were not notifications to send -- at ' . Carbon::now()->format('Y-m-d H:i'));
        }

    }


}
