<?php

use App\Enums\ArticleStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('articles')->delete();
        factory(App\Article::class, 120)->create();
        factory(App\Article::class, 60)->create(['activeStatus' => ArticleStatus::Draft]);
    }

}
