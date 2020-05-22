<?php

use App\Photo;
use App\Event;
use Faker\Generator as Faker;

$factory->define(
    Photo::class,
    function (Faker $faker) {
        return [
            'image_path' => 'images/test.jpeg',
            'event_id' => $faker->numberBetween(1, 10)
        ];
    }
);
