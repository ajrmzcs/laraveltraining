@component('mail::message')
# This is your appointment notification

Appointment Details:

Title: {{ $appointment->title }}

Description: {{ $appointment->description }}

Due date: {{ $appointment->appointment_date }}

@component('mail::button', ['url' => "http://laraveltraining.test/appointment/$appointment->id"])
See your Appointment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
