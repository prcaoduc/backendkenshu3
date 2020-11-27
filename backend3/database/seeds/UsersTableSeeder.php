<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();
        factory(User::class, 50)->create();
    }

}
