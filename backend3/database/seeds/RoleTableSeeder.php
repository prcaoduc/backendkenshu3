<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editor = Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'permissions' => [
                'release.publish'   => true,
                'release.update'    => true,
                'release.draft'     => true,
                'release.create'    => true,
            ]
        ]);
        $journalist = Role::create([
            'name' => 'Journalist',
            'slug' => 'journalist',
            'permissions' => [
                'release.create'    => true,
            ]
        ]);
        $customer = Role::create([
            'name' => 'Customer',
            'slug' => 'customer',
            'permissions' => [
            ]
        ]);
    }
}
