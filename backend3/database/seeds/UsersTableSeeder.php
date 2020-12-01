<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();
        factory(User::class, 50)->create();

        $journalist_role = Role::where('slug', 'journalist')->first();
        $editor_role = Role::where('slug', 'editor')->first();

        $user1 = factory(User::class)->create([
            'name' => 'ジャーナリスト 1',
            'email' => 'jl1@test.test',
        ]);
        $user1->roles()->attach($journalist_role->id);

        $user2 = factory(User::class)->create([
            'name' => 'ジャーナリスト 2',
            'email' => 'jl2@test.test',
        ]);
        $user2->roles()->attach($journalist_role->id);

        $user3 = factory(User::class)->create([
            'name' => 'エディター',
            'email' => 'ed@test.test',
        ]);
        $user3->roles()->attach([$editor_role->id, $journalist_role->id]);
    }
}
