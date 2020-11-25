<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    $user = DB::table('users')->inRandomOrder()->first();
    return [
        'title' => $faker->name,
        'content' => $faker->realText,
        'created_at' => $faker->dateTimeBetween('-10 years', 'now', null),
        'author_id' => $user->id,
    ];
});
