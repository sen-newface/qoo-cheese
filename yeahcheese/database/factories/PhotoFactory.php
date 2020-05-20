<?php

use App\Photo;
use Faker\Generator as Faker;

$factory->define(
    Photo::class, function (Faker $faker) {
        return [
        'image_path' => $faker->url,
        'event_id' => $faker->numberBetween(1, 10)
        ];
    }
);
