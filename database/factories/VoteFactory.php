<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Document;
use App\Models\Session;
use App\Models\User;
use App\Models\Vote;
use Faker\Generator as Faker;

$factory->define(Vote::class, function (Faker $faker) {
    return [
        'document_id' => factory(Document::class),
        'session_id' => factory(Session::class),
        'user_id' => factory(User::class),
        'vote_category_id' => 1,
    ];
});
