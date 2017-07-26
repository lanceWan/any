<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User', 1)->create([
        	'username' => 'iwanli',
        	'name' => '晚黎',
        	'email' => '709344897@qq.com',
        	'password' => bcrypt('123123'),
        ])->each(function ($item, $key)
        {
        	$item->attachRole(\App\Models\Role::create([
        		'name' => 'admin',
        		'slug' => 'admin',
        		'description' => '超级管理员',
        	]));
        });
    }
}
