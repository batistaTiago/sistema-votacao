<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DocumentStatus;
use Faker\Generator as Faker;

$factory->define(DocumentStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3)
    ];
});
