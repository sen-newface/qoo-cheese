<?php

use App\Photo;
use App\Event;
use Faker\Generator as Faker;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'image_path' => $faker->url,
        'event_id' => Event::inRandomOrder()->first()->id
    ];
});
