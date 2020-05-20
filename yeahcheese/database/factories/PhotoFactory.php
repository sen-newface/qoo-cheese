<?php

use App\Photo;
use Faker\Generator as Faker;

$factory->define(
    Photo::class, function (Faker $faker) {
        return [
        'image_path' => $faker->imageUrl,
        'image_path' => $faker->imageUrl(),
        'event_id' => $faker->numberBetween(1, 10)
        ];
    }
);
