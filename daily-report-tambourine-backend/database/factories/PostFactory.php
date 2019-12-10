<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        "user_id" => $faker->numberBetween($min = 1, $max = 50),
        "body" => $faker->realText($maxNbChars = 50),
        "created_at" => $faker->date(),
        "updated_at" => $faker->date(),
    ];
});
