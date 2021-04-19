<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Session;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Session::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'datetime_start' => null,
        'datetime_end' => null,
        'session_status_id' => 1,
        'user_id' => factory(User::class),
    ];
});
