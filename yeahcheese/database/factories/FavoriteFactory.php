<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Favorite;
use Faker\Generator as Faker;

$factory->define(
    Favorite::class,
    function (Faker $faker) {
        return [
            'user_id' => $faker->regexify('[1-5]{1}'),
            'photo_id' => function () {
                return factory(App\Photo::class)->create()->id;
            }
        ];
    }
);
