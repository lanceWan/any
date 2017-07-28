<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Role;

use Closure;
use Route;
class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->checkPermission();
        return $this->checkPermission() ? $next($request) : abort(500, '没有权限访问');
    }

    /**
     * 验证用户权限
     * @author 晚黎
     * @date   2017-07-24T16:46:35+0800
     * @return [type]                   [description]
     */
    public function checkPermission()
    {
        $method = $this->getCurrentControllerMethod();
        $actionName = $this->getCurrentControllerName();

        return $this->validationUserPermission(strtolower($actionName.'.'.$method));
    }

    /**
     * 获取用户权限并验证
     * @author 晚黎
     * @date   2017-07-24T14:42:28+0800
     * @param  [type]                   $permission [description]
     * @return [type]                               [description]
     */
    public function validationUserPermission($permission)
    {
        $user = auth()->user();
        $userPermissions = getCurrentPermission($user);

        $hasItem = in_array($permission, $userPermissions['permissions']);

        $isAdmin = $this->isAdmin($userPermissions);
        /**
         * 权限不存在
         */
        if (!$hasItem) {

            if (in_array($permission, $userPermissions['allPermissions']) && !$isAdmin) {
                return false;
            }

            $newPermssion = $this->createPermission($permission);

            if ($isAdmin) {
                $role = Role::where('slug', 'admin')->first();
                $user->attachPermission($newPermssion);
                setUserPermissions($user);
            }


        }

        return $isAdmin ? true : $hasItem;

    }

    /**
     * 判断是否超级管理员
     * @author 晚黎
     * @date   2017-07-24T16:52:01+0800
     * @param  [type]                   $user [description]
     * @return boolean                        [description]
     */
    public function isAdmin($userPermissions)
    {
        return in_array('admin', $userPermissions['roles']);
    }

    /**
     * 创建权限
     * @author 晚黎
     * @date   2017-07-24T15:38:13+0800
     * @param  [type]                   $user [description]
     * @return [type]                         [description]
     */
    public function createPermission($permission)
    {
        // 添加权限
        return Permission::firstOrCreate([
            'slug' => $permission,
        ],[
            'name' => $permission,
            'description' => $permission,
        ]);
    }

    /**
     * 获取当前控制器方法
     * @author 晚黎
     * @date   2017-07-24T14:23:52+0800
     * @return [type]                   [description]
     */
    private function getCurrentControllerMethod()  
    {  
        return $this->getCurrentActionAttribute()['method'];
    }

    /**
     * 获取当前控制器名称
     * @author 晚黎
     * @date   2017-07-24T14:24:04+0800
     * @return [type]                   [description]
     */
    private function getCurrentControllerName()  
    {  
        return $this->getCurrentActionAttribute()['controller'];
    }  

    /**
     * 获取当前控制器相关属性
     * @author 晚黎
     * @date   2017-07-24T14:24:14+0800
     * @return [type]                   [description]
     */
    private function getCurrentActionAttribute()  
    {  
        $action = Route::currentRouteAction();
        list($class, $method) = explode('@', $action);
        return ['controller' => class_basename($class), 'method' => $method];
    } 


}
