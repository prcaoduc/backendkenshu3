<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    $users = collect();
    $users->push(DB::table('users')->where('email', 'jl1@test.test')->first());
    $users->push(DB::table('users')->where('email', 'jl2@test.test')->first());
    $users->push(DB::table('users')->where('email', 'ed@test.test')->first());
    return [
        'title' => $faker->name,
        'content' => $faker->realText,
        'created_at' => $faker->dateTimeBetween('-10 years', 'now', null),
        'author_id' => $users->random()->id,
    ];
});
