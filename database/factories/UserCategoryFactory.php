<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserCategory;
use Faker\Generator as Faker;

$factory->define(UserCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word(6)
    ];
});
