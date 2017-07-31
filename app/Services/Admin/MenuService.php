<?php
namespace App\Services\Admin;

use Facades\ {
    App\Repositories\Eloquent\MenuRepositoryEloquent,
    App\Repositories\Eloquent\PermissionRepositoryEloquent
};

use Exception;

class MenuService {

	protected $module = 'menu';

	protected $indexRoute = 'menu.index';

	protected $createRoute = 'menu.create';

	protected $showRoute = 'menu.show';

	protected $editRoute = 'menu.edit';

	protected $destroyRoute = 'menu.destroy';

	/**
	 * 获取菜单数据
	 * @Author   晚黎
	 * @DateTime 2017-07-31T21:44:41+0800
	 * @return   [type]                   [description]
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
	 * @Author   晚黎
	 * @DateTime 2017-07-31T21:42:01+0800
	 * @param    [type]                   $menus [description]
	 * @param    integer                  $pid   [description]
	 * @return   [type]                          [description]
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
	 * @Author   晚黎
	 * @DateTime 2017-07-31T21:42:12+0800
	 * @return   [type]                   [description]
	 */
	private function sortMenuSetCache()
	{
		$menus = MenuRepositoryEloquent::all()->toArray();
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
	 * @Author   晚黎
	 * @DateTime 2017-07-31T22:53:43+0800
	 * @return   [type]                   [description]
	 */
	public function create()
	{
		$menus = $this->getMenuList();
		$permissions = PermissionRepositoryEloquent::all(['name']);
		return compact('menus', 'permissions');
	}

}