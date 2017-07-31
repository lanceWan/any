<?php
namespace App\Services\Admin;

use Facades\ {
    App\Repositories\Eloquent\RoleRepositoryEloquent,
    App\Repositories\Eloquent\PermissionRepositoryEloquent,
    Yajra\Datatables\Html\Builder
};

use App\Traits\DatatableActionButtonTrait;

use Datatables;

use Exception;

class RoleService {

	use DatatableActionButtonTrait;

	protected $module = 'role';

	protected $indexRoute = 'role.index';

	protected $createRoute = 'role.create';

	protected $editRoute = 'role.edit';

	protected $destroyRoute = 'role.destroy';

	/**
	 * 角色首页
	 * @Author   晚黎
	 * @DateTime 2017-07-26T22:42:27+0800
	 * @return   [type]                   [description]
	 */
	public function index()
	{
		if (request()->ajax()) {
			return $this->ajaxData();
		}

		$html = Builder::parameters([
				'searchDelay' => 350,
			    'language' => [
			        'url' => url(getThemeAssets('dataTables/language/zh.json', true))
			    ],
			    'drawCallback' => <<<Eof
					function() {
				        LaravelDataTables["dataTableBuilder"].$('.tooltips').tooltip( {
				          placement : 'top',
				          html : true
				        });
			        },
Eof
			])->addIndex(['data' => 'DT_Row_Index', 'name' => 'DT_Row_Index', 'title' => trans('common.number')])
			->addColumn(['data' => 'name', 'name' => 'name', 'title' => trans('permission.name')])
	        ->addColumn(['data' => 'slug', 'name' => 'slug', 'title' => trans('permission.slug')])
	        ->addColumn(['data' => 'description', 'name' => 'description', 'title' => trans('permission.description')])
	        ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => trans('permission.created_at')])
	        ->addColumn(['data' => 'updated_at', 'name' => 'updated_at', 'title' => trans('permission.updated_at')])
	        ->addAction(['data' => 'action', 'name' => 'action', 'title' => trans('common.action')]);

        return compact('html');
	}

	/**
	 * datatable数据
	 * @author 晚黎
	 * @date   2017-07-27T10:20:36+0800
	 * @return [type]                   [description]
	 */
	public function ajaxData()
	{
		return Datatables::of(RoleRepositoryEloquent::all())
			->addIndexColumn()
			->addColumn('action', function ($permission)
			{
				return $this->getActionButtonAttribute($permission->id);
			})
			->make(true);
	}

	/**
	 * 重写datatable action按钮
	 * @author 晚黎
	 * @date   2017-07-31T10:11:27+0800
	 * @param  [type]                   $id [description]
	 * @return [type]                       [description]
	 */
	public function getActionButtonAttribute($id)
	{
		return $this->getModalShowActionButtion($id).
				$this->getEditActionButton($id).
				$this->getDestroyActionButton($id);
	}

	/**
	 * 创建角色角色
	 * @Author   晚黎
	 * @DateTime 2017-07-29T11:37:05+0800
	 * @return   [type]                   [description]
	 */
	public function create()
	{
		return $this->getAllPermissions();
	}
	/**
	 * 获取所有角色
	 * @author 晚黎
	 * @date   2017-07-31T09:50:40+0800
	 * @return [type]                   [description]
	 */
	public function getAllPermissions()
	{
		$array = [];
		$permissions = PermissionRepositoryEloquent::all(['id', 'name', 'slug']);
		if ($permissions->isNotEmpty()) {
            foreach ($permissions as $v) {
                $temp = explode('.', $v->slug);
                $array[$temp[0]][] = $v->toArray();
            }
		}
        return $array;
	}

	/**
	 * 添加角色
	 * @Author   晚黎
	 * @DateTime 2017-07-26T22:42:59+0800
	 * @param    [type]                   $attributes [description]
	 * @return   [type]                               [description]
	 */
	public function store($attributes)
	{
		try {
			$result = RoleRepositoryEloquent::create($attributes);
			if ($result && isset($attributes['permission']) && $attributes['permission']) {
				// 更新角色权限关系
                $result->permissions()->sync($attributes['permission']);
			}
			flash_info($result,trans('common.create_success'),trans('common.create_error'));
			return isset($attributes['rediret']) ? $this->createRoute : $this->indexRoute;
		} catch (Exception $e) {
			return $this->createRoute;
		}
	}

	/**
	 * 查看
	 * @author 晚黎
	 * @date   2017-07-31T10:20:49+0800
	 * @param  [type]                   $id [description]
	 * @return [type]                       [description]
	 */
	public function show($id)
	{
		try {
			$role = RoleRepositoryEloquent::with('permissions')->find(decodeId($id, $this->module));
			return compact('role');
		} catch (Exception $e) {
			flash(trans('common.find_error'), 'danger');
			return redirect()->route($this->indexRoute);
		}
	}


	/**
	 * 修改角色
	 * @author 晚黎
	 * @date   2017-07-27T10:44:41+0800
	 * @param  [type]                   $id [description]
	 * @return [type]                       [description]
	 */
	public function edit($id)
	{
		try {
			$role = RoleRepositoryEloquent::with('permissions')->find(decodeId($id, $this->module));
			$permissions = $this->getAllPermissions();
			return compact('role', 'permissions');
		} catch (Exception $e) {
			flash(trans('common.find_error'), 'danger');
			return redirect()->route($this->indexRoute);
		}
	}

	/**
	 * 修改数据
	 * @author 晚黎
	 * @date   2017-07-27T11:35:33+0800
	 * @param  [type]                   $attributes [description]
	 * @param  [type]                   $id         [description]
	 * @return [type]                               [description]
	 */
	public function update($attributes, $id)
	{
		try {
			$result = RoleRepositoryEloquent::update($attributes, decodeId($id, $this->module));
			if ($result) {
				// 更新角色权限关系
				if (isset($attributes['permission'])) {
					$result->permissions()->sync($attributes['permission']);
				}else{
					$result->permissions()->sync([]);
				}
			}
			flash_info($result,trans('common.edit_success'),trans('common.edit_error'));
			return $result ? $this->indexRoute : $this->editRoute;
		} catch (Exception $e) {
			flash(trans('common.edit_error'), 'danger');
			return $this->editRoute;
		}
	}

	/**
	 * 删除数据
	 * @author 晚黎
	 * @date   2017-07-27T13:57:40+0800
	 * @param  [type]                   $id [description]
	 * @return [type]                       [description]
	 */
	public function destroy($id)
	{
		try {
			$result = RoleRepositoryEloquent::delete(decodeId($id, $this->module));
			flash_info($result,trans('common.destroy_success'),trans('common.destroy_error'));
		} catch (Exception $e) {
			flash(trans('common.destroy_error'), 'danger');
		}
	}

}