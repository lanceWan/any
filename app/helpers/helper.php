<?php
/**
 * 主题下视图文件路径
 */
if(!function_exists('getThemeView')){
	function getThemeView($view)
	{
		return 'themes.admin.'.getTheme().'.'.$view;
	}
}

/**
 * 获取主题
 */
if(!function_exists('getTheme')){
	function getTheme()
	{
		if (cache()->has('theme')) {
			return cache('theme');
		}
		$theme = config('admin.global.theme');
		cache()->forever('theme', $theme);
		return $theme;
	}
}

/**
 * 获取页面资源文件
 */
if(!function_exists('getThemeAssets')){
	function getThemeAssets($asset, $vendors = false)
	{
		return $vendors ? 'vendors/'.$asset : 'themes/admin/'.getTheme().'/'.$asset;
	}
}

/**
 * 刷新用户权限、角色
 */
if(!function_exists('setUserPermissions')){
	function setUserPermissions($user)
	{
		$rolePermissions = $user->rolePermissions()->get()->pluck('slug');
        $userPermissions = $user->userPermissions()->get()->pluck('slug');
        $permissions = array_unique($rolePermissions->merge($userPermissions)->all());

        $roles = $user->getRoles()->pluck('slug')->all();
        $allPermissions = \App\Models\Permission::all()->pluck('slug')->all();

        // 缓存用户权限
        cache()->forever('user_'.$user->id, [
        	'permissions' => $permissions,
        	'roles' => $roles,
        	'allPermissions' => $allPermissions
        ]);
	}
}

/**
 * 清空缓存
 */
if(!function_exists('cacheClear')){
	function cacheClear()
	{
		cache()->flush();
	}
}
/**
 * 获取当前用户权限、角色
 */
if(!function_exists('getCurrentPermission')){
	function getCurrentPermission($user)
	{
		$key = 'user_'.$user->id;

		if (cache()->has($key)) {
			return cache($key);
		}

		setUserPermissions($user);

		return cache($key);
	}
}
/**
 * 操作提示信息
 */
if(!function_exists('flash_info')){
	function flash_info($result,$successMsg = 'success !',$errorMsg = 'something error !')
	{
		return $result ? flash($successMsg,'success')->important() : flash($errorMsg,'danger')->important();
	}
}

/**
 * 加密
 */
if(!function_exists('encodeId')){
	function encodeId($id,$connection = 'main')
	{
		if (!config('hashids.connections.'.$connection)) {
			$connection = 'main';
		}
		// 获取加密配置
		$settings = config('admin.global.encrypt');
		// 判断是否开启加密设置
		if(isset($settings[$connection]) && $settings[$connection]){
			return Hashids::connection($connection)->encode($id);
		}
		return $id;
	}
}

if(!function_exists('decodeId')){
	function decodeId($id,$connection = 'main', $type = false)
	{
		if (!config('hashids.connections.'.$connection)) {
			$connection = 'main';
		}

		// 获取加密配置
		$settings = config('admin.global.encrypt');
		// 判断是否开启加密设置
		
		if(isset($settings[$connection]) && $settings[$connection]){
			$id = Hashids::connection($connection)->decode($id);
			if ($id) {
				return $type ? $id:$id[0];
			}
			flash(trans('common.decode_error'), 'danger');
			return 0;
		}
		return $id;
	}
}

if(!function_exists('haspermission')){
	function haspermission($permission)
	{
        $check = false;
        if (auth()->check()) {
            
            $user = auth()->user();
            $userPermissions =  getCurrentPermission($user);

            $check = in_array($permission, (array)$userPermissions['permissions']);

            if (in_array('admin', (array)$userPermissions['roles']) && !$check) {
                $newPermission = \App\Models\Permission::firstOrCreate([
                    'slug' => $permission,
                ],[
                    'name' => $permission,
                    'description' => $permission,
                ]);
                $role = \App\Models\Role::where('slug', 'admin')->first();
                $role->attachPermission($newPermission);
                setUserPermissions($user);
                $check = true;
            }
        }
        return $check;
	}
}