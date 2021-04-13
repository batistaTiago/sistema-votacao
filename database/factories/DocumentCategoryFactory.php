<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DocumentCategory;
use Faker\Generator as Faker;

$factory->define(DocumentCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3)
    ];
});
