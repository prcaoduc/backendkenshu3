<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('articles')->delete();
        factory(App\Article::class, 120)->create();
    }

}
