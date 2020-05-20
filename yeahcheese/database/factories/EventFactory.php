<?php

use App\Event;
use Faker\Generator as Faker;

$factory->define(
    Event::class, function (Faker $faker) {
        $start_date = $faker->date($format='Y-m-d', $max='now');
        return [
        'name' => $faker->city,
        'start_date' => $start_date,
        'end_date' => $faker->date($format='Y-m-d', $min=$start_date, $max='now'),
        'user_id' => $faker->regexify('[1-5]{1}')
        ];
    }
);
