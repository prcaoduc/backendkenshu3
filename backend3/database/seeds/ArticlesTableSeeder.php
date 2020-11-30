<?php

use App\Enums\ArticleStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('articles')->delete();
        $user1 = DB::table('users')->where('email', 'jl1@test.test')->first();
        $user2 = DB::table('users')->where('email', 'jl2@test.test')->first();
        $user3 = DB::table('users')->where('email', 'ed@test.test')->first();
        factory(App\Article::class, 60)->create(['author_id' => $user1->id]);
        factory(App\Article::class, 60)->create(['author_id' => $user2->id]);
        factory(App\Article::class, 60)->create(['author_id' => $user3->id]);
        factory(App\Article::class, 60)->create(['activeStatus' => ArticleStatus::Draft]);
    }

}
