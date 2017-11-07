<?php
namespace App\Services\Admin;

use Facades\ {
    App\Repositories\Eloquent\MenuRepository,
    App\Repositories\Eloquent\PermissionRepository
};

use Exception;

class MenuService {
	
	protected $module = 'menu';
	
	/**
	 * 获取菜单数据
	 * @author 晚黎
	 * @date   2017-11-06
	 * @return [type]     [description]
	 */
	public function getMenuList()
	{
		// 判断数据是否缓存
		if (cache()->has(config('admin.global.cache.menuList'))) {
			return cache()->get(config('admin.global.cache.menuList'));
		}
		return $this->sortMenuSetCache();
	}
	
	/**
	 * 递归菜单数据
	 * @author 晚黎
	 * @date   2017-11-06
	 * @param  [type]     $menus [description]
	 * @param  integer    $pid   [description]
	 * @return [type]            [description]
	 */
	private function sortMenu($menus,$pid=0)
	{
		$arr = [];
		if (empty($menus)) {
			return '';
		}
		foreach ($menus as $key => $v) {
			if ($v['pid'] == $pid) {
				$arr[$key] = $v;
				$arr[$key]['child'] = self::sortMenu($menus,$v['id']);
			}
		}
		return $arr;
	}
	
	/**
	 * 排序子菜单并缓存
	 * @author 晚黎
	 * @date   2017-11-06
	 * @return [type]     [description]
	 */
	private function sortMenuSetCache()
	{
		$menus = MenuRepository::all()->toArray();
		if ($menus) {
			$menuList = $this->sortMenu($menus);
			foreach ($menuList as $key => &$v) {
				if ($v['child']) {
					$sort = array_column($v['child'], 'sort');
					array_multisort($sort,SORT_DESC,$v['child']);
				}
			}
			// 缓存菜单数据
			cache()->forever(config('admin.global.cache.menuList'),$menuList);
			return $menuList;
			
		}
		return '';
	}
	/**
	 * 添加菜单视图
	 * @author 晚黎
	 * @date   2017-11-06
	 * @return [type]     [description]
	 */
	public function create()
	{
		$menus = $this->getMenuList();
		$permissions = PermissionRepository::all(['name', 'slug']);
		return compact('menus', 'permissions');
	}
	/**
	 * 添加数据
	 * @author 晚黎
	 * @date   2017-11-06
	 * @param  [type]     $attributes [description]
	 * @return [type]                 [description]
	 */
	public function store($attributes)
	{
		try {
			$result = MenuRepository::create($attributes);
			if ($result) {
				// 更新缓存
				$this->sortMenuSetCache();
			}
			return [
				'status' => $result,
				'message' => $result ? trans('common.create_success'):trans('common.create_error'),
			];
		} catch (Exception $e) {
			return [
				'status' => false,
				'message' => trans('common.create_error'),
			];
		}
	}
	/**
	 * 查看数据
	 * @author 晚黎
	 * @date   2017-11-06
	 * @param  [type]     $id [description]
	 * @return [type]         [description]
	 */
	public function show($id)
	{
		try {
			$menus = $this->getMenuList();
			$menu = MenuRepository::find(decodeId($id, $this->module));
			return compact('menus', 'menu');
		} catch (Exception $e) {
			abort(500);
		}
	}


	public function edit($id)
	{
		try {
			$attr = $this->show($id);
			$permissions = PermissionRepository::all(['name', 'slug']);
			return array_merge($attr, compact('permissions'));
		} catch (Exception $e) {
			abort(500);
		}
	}
	/**
	 * 修改数据
	 * @author 晚黎
	 * @date   2017-11-06
	 * @param  [type]     $attributes [description]
	 * @param  [type]     $id         [description]
	 * @return [type]                 [description]
	 */
	public function update($attributes, $id)
	{
		try {
			$isUpdate = MenuRepository::update($attributes, decodeId($id, $this->module));
			if ($isUpdate) {
				// 更新缓存
				$this->sortMenuSetCache();
			}
			return [
				'status' => $isUpdate,
				'message' => $isUpdate ? trans('common.edit_success'):trans('.common.edit_error'),
			];
		} catch (Exception $e) {
			return [
				'status' => false,
				'message' => trans('common.edit_error'),
			];
		}
	}
	/**
	 * 删除数据
	 * @author 晚黎
	 * @date   2017-11-06
	 * @param  [type]     $id [description]
	 * @return [type]         [description]
	 */
	public function destroy($id)
	{
		try {
			$result = MenuRepository::delete(decodeId($id, $this->module));
			if ($result) {
				$this->sortMenuSetCache();
			}
			flash_info($result,trans('common.destroy_success'),trans('common.destroy_error'));
		} catch (Exception $e) {
			flash(trans('common.destroy_error'), 'danger');
		}
	}
	/**
	 * 清除缓存
	 * @author 晚黎
	 * @date   2017-11-06
	 * @return [type]     [description]
	 */
	public function cacheClear()
	{
		cache()->forget(config('admin.global.cache.menuList'));
		flash(trans('common.cache_clear'), 'success')->important();
	}
	
}