<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Appointment::class, function (Faker $faker) {

    $baseDate = Carbon::create(2018, 04, 25)->setTime(7,0,0);

    $appointmentDate = $baseDate->addDays(rand(1,7))->addHours(rand(1,12))->format('Y-m-d H:i:s');

    $notificationDate = (new Carbon($appointmentDate))->subMinutes(10)->format('Y-m-d H:i:s');

    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'appointment_date' => $appointmentDate,
        'notification_date' => $notificationDate,
        'user_id' => 1,
    ];
});
