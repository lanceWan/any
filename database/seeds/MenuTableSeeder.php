<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
        	'name' => "控制台",
	        'pid' => 0,
	        'icon' => "fa fa-dashboard",
	        'slug' => "homecontroller.index",
	        'url' => "admin",
	        'active' => "admin",
	        'description' => "后台首页",
        ]);


        $system = Menu::create([
        	'name' => "系统管理",
	        'pid' => 0,
	        'icon' => "fa fa-cog",
	        'slug' => "system.manage",
	        'active' => "admin/role*,admin/permission*,admin/user*,admin/menu*",
	        'description' => "系统功能管理",
        ]);

        Menu::create([
        	'name' => "用户管理",
	        'pid' => $system->id,
	        'icon' => "fa fa-users",
	        'slug' => "usercontroller.index",
	        'url' => "admin/user",
	        'active' => "admin/user*",
	        'description' => "显示用户管理",
        ]);

        Menu::create([
        	'name' => "角色管理",
	        'pid' => $system->id,
	        'icon' => "fa fa-male",
	        'slug' => "rolecontroller.index",
	        'url' => "admin/role",
	        'active' => "admin/role*",
	        'description' => "显示角色管理",
        ]);

        Menu::create([
        	'name' => "权限管理",
	        'pid' => $system->id,
	        'icon' => "fa fa-paper-plane",
	        'slug' => "permissioncontroller.index",
	        'url' => "admin/permission",
	        'active' => "admin/permission*",
	        'description' => "显示权限管理",
        ]);

        Menu::create([
        	'name' => "菜单管理",
	        'pid' => $system->id,
	        'icon' => "fa fa-navicon",
	        'slug' => "menucontroller.index",
	        'url' => "admin/menu",
	        'active' => "admin/menu*",
	        'description' => "显示菜单管理",
        ]);
    }
}
