<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SessionStatus;
use Faker\Generator as Faker;

$factory->define(SessionStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3)
    ];
});
