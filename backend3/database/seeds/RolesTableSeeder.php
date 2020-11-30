<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
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
                'article.publish'   => true,
                'article.update'    => true,
                'article.create'    => true,
                'article.delete'    => true,
                'article.destroy'   => true,
            ]
        ]);
        $journalist = Role::create([
            'name' => 'Journalist',
            'slug' => 'journalist',
            'permissions' => [
                'article.create'    => true,
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
