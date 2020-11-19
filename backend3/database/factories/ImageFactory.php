<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    $users_id = DB::table('users')->inRandomOrder()->first();
    return [
        'url' => $faker->name,
        'user_id' => $users_id->id,
    ];
});
