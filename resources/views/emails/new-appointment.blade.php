@component('mail::message')
# You have a new Appointment in Laravel Training App

Appointment Details:

Title: {{ $appointment->title }}

Description: {{ $appointment->description }}

Due date: {{ $appointment->appointment_date }}

Send notification: {{ $appointment->notification_date }}

@component('mail::button', ['url' => "http://laraveltraining.test/appointment/$appointment->id"])
See your Appointment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
