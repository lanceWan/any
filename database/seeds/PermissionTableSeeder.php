<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * 系统管理
         */
        Permission::create([
            'name' => '系统管理',
            'slug' => 'system.manage',
            'description' => '系统管理'
        ]);

        Permission::create([
            'name' => '后台语言切换',
            'slug' => 'settingcontroller.language',
            'description' => '后台语言切换'
        ]);
        /**
         * 显示菜单列表
         */
        Permission::create([
            'name' => '显示菜单列表',
            'slug' => 'menucontroller.index',
            'description' => '显示菜单列表'
        ]);
        /**
         * 创建菜单
         */
        Permission::create([
            'name' => '创建菜单',
            'slug' => 'menucontroller.create',
            'description' => '创建菜单'
        ]);
        /**
         * 创建菜单
         */
        Permission::create([
            'name' => '创建菜单视图',
            'slug' => 'menucontroller.store',
            'description' => '创建菜单视图'
        ]);
        /**
         * 删除菜单
         */
        Permission::create([
            'name' => '删除菜单',
            'slug' => 'menucontroller.destroy',
            'description' => '删除菜单'
        ]);
        /**
         * 修改菜单
         */
        Permission::create([
            'name' => '修改菜单视图',
            'slug' => 'menucontroller.edit',
            'description' => '修改菜单视图'
        ]);

        /**
         * 修改菜单
         */
        Permission::create([
            'name' => '修改菜单',
            'slug' => 'menucontroller.update',
            'description' => '修改菜单'
        ]);
        /**
         * 查看菜单信息
         */
        Permission::create([
            'name' => '查看菜单',
            'slug' => 'menucontroller.show',
            'description' => '查看菜单'
        ]);
        /**
         * 清除菜单缓存
         */
        Permission::create([
            'name' => '清除菜单缓存',
            'slug' => 'menucontroller.cacheclear',
            'description' => '清除菜单缓存'
        ]);
        /////////////
        //角色管理 //
        ////////////
        /**
         * 显示角色列表
         */
        Permission::create([
            'name' => '显示角色列表',
            'slug' => 'rolecontroller.index',
            'description' => '显示角色列表'
        ]);
        /**
         * 创建角色
         */
        Permission::create([
            'name' => '创建角色视图',
            'slug' => 'rolecontroller.create',
            'description' => '创建角色视图'
        ]);
        /**
         * 创建角色
         */
        Permission::create([
            'name' => '创建角色',
            'slug' => 'rolecontroller.store',
            'description' => '创建角色'
        ]);
        /**
         * 删除角色
         */
        Permission::create([
            'name' => '删除角色',
            'slug' => 'rolecontroller.destroy',
            'description' => '删除角色'
        ]);
        /**
         * 修改角色视图
         */
        Permission::create([
            'name' => '修改角色视图',
            'slug' => 'rolecontroller.edit',
            'description' => '修改角色视图'
        ]);

        /**
         * 修改角色
         */
        Permission::create([
            'name' => '修改角色',
            'slug' => 'rolecontroller.update',
            'description' => '修改角色'
        ]);
        /**
         * 查看角色权限
         */
        Permission::create([
            'name' => '查看角色权限',
            'slug' => 'rolecontroller.show',
            'description' => '查看角色权限'
        ]);
        /////////////
        //权限管理 //
        ////////////
        /**
         * 显示权限列表
         */
        Permission::create([
            'name' => '显示权限列表',
            'slug' => 'permissioncontroller.index',
            'description' => '显示权限列表'
        ]);
        /**
         * 创建权限视图
         */
        Permission::create([
            'name' => '创建权限视图',
            'slug' => 'permissioncontroller.create',
            'description' => '创建权限视图'
        ]);
        /**
         * 创建权限
         */
        Permission::create([
            'name' => '创建权限',
            'slug' => 'permissioncontroller.store',
            'description' => '创建权限'
        ]);
        /**
         * 删除权限
         */
        Permission::create([
            'name' => '删除权限',
            'slug' => 'permissioncontroller.destroy',
            'description' => '删除权限'
        ]);
        /**
         * 修改权限视图
         */
        Permission::create([
            'name' => '修改权限视图',
            'slug' => 'permissioncontroller.edit',
            'description' => '修改权限视图'
        ]);
        /**
         * 修改权限
         */
        Permission::create([
            'name' => '修改权限',
            'slug' => 'permissioncontroller.update',
            'description' => '修改权限'
        ]);
        /////////////
        //用户管理 //
        ////////////
        /**
         * 显示用户列表
         */
        Permission::create([
            'name' => '显示用户列表',
            'slug' => 'usercontroller.index',
            'description' => '显示用户列表'
        ]);
        /**
         * 创建用户视图
         */
        Permission::create([
            'name' => '创建用户视图',
            'slug' => 'usercontroller.create',
            'description' => '创建用户视图'
        ]);

        /**
         * 创建用户
         */
        Permission::create([
            'name' => '创建用户',
            'slug' => 'usercontroller.store',
            'description' => '创建用户'
        ]);
        /**
         * 修改用户信息
         */
        Permission::create([
            'name' => '修改用户视图',
            'slug' => 'usercontroller.edit',
            'description' => '修改用户视图'
        ]);
        /**
         * 修改用户信息
         */
        Permission::create([
            'name' => '修改用户',
            'slug' => 'usercontroller.update',
            'description' => '修改用户'
        ]);
        /**
         * 删除用户
         */
        Permission::create([
            'name' => '删除用户',
            'slug' => 'usercontroller.destroy',
            'description' => '删除用户'
        ]);
        /**
         * 查看用户信息
         */
        Permission::create([
            'name' => '查看用户信息',
            'slug' => 'usercontroller.show',
            'description' => '查看用户信息'
        ]);

        /**
         * 后台首页权限
         */
        Permission::create([
            'name' => '后台首页',
            'slug' => 'homecontroller.index',
            'description' => '后台首页'

        ]);
        
    }
}
