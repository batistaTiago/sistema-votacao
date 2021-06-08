<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentStatus;
use App\Models\VoteCategory;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(Document::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'attachment' => UploadedFile::fake()->create('document.pdf', 1023, 'application/pdf'),
        'document_category_id' => factory(DocumentCategory::class),
        'document_status_id' => factory(DocumentStatus::class),
        'votes_are_secret' => true,
        'protocol_number' => $faker->numberBetween(10000, 20000)
    ];
});
