<?php
namespace App\Services\Admin;

use Facades\ {
    App\Repositories\Eloquent\UserRepositoryEloquent,
    App\Repositories\Eloquent\RoleRepositoryEloquent,
    App\Repositories\Eloquent\PermissionRepositoryEloquent,
    Yajra\Datatables\Html\Builder
};

use App\Traits\DatatableActionButtonTrait;

use Datatables;

use Exception;

class UserService {

	use DatatableActionButtonTrait;

	protected $module = 'user';

	protected $indexRoute = 'user.index';

	protected $createRoute = 'user.create';

	protected $showRoute = 'user.show';

	protected $editRoute = 'user.edit';

	protected $destroyRoute = 'user.destroy';

	/**
	 * 首页
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
			->addColumn(['data' => 'name', 'name' => 'name', 'title' => trans('user.name')])
	        ->addColumn(['data' => 'username', 'name' => 'username', 'title' => trans('user.username')])
	        ->addColumn(['data' => 'email', 'name' => 'email', 'title' => trans('user.email')])
	        ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => trans('user.created_at')])
	        ->addColumn(['data' => 'updated_at', 'name' => 'updated_at', 'title' => trans('user.updated_at')])
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
		return Datatables::of(UserRepositoryEloquent::all())
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
		return $this->getShowActionButtion($id).
				$this->getEditActionButton($id).
				$this->getDestroyActionButton($id);
	}

	/**
	 * 创建
	 * @Author   晚黎
	 * @DateTime 2017-07-29T11:37:05+0800
	 * @return   [type]                   [description]
	 */
	public function create()
	{
		$permissions = $this->getAllPermissions();
		$roles = $this->getAllRole();
		return compact('permissions', 'roles');
	}
	/**
	 * 获取所有权限
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
	 * 获取所有角色
	 * @author 晚黎
	 * @date   2017-07-31T10:56:22+0800
	 * @return [type]                   [description]
	 */
	private function getAllRole()
	{
		return RoleRepositoryEloquent::all(['id', 'name']);
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
			$attributes['password'] = bcrypt($attributes['password']);
			$result = UserRepositoryEloquent::create($attributes);
			if ($result) {
				// 角色与用户关系
				if (isset($attributes['role']) && $attributes['role']) {
					$result->roles()->sync($attributes['role']);
				}
				// 权限与用户关系
				if (isset($attributes['permission']) && $attributes['permission']) {
					$result->userPermissions()->sync($attributes['permission']);
				}
			}
			flash_info($result,trans('common.create_success'),trans('common.create_error'));
			return isset($attributes['rediret']) ? $this->createRoute : $this->indexRoute;
		} catch (Exception $e) {
			flash(trans('common.create_error'), 'danger');
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
			$user = UserRepositoryEloquent::with(['userPermissions', 'roles'])->find(decodeId($id, $this->module));
			$permissions = $this->getAllPermissions();
			$roles = $this->getAllRole();
			return compact('user', 'permissions', 'roles');
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
			$user = UserRepositoryEloquent::with(['userPermissions', 'roles'])->find(decodeId($id, $this->module));
			$permissions = $this->getAllPermissions();
			$roles = $this->getAllRole();
			return compact('user', 'permissions', 'roles');
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
			// 修改密码
			if ($attributes['password']) {
				$attributes['password'] = bcrypt($attributes['password']);
			}else{
				unset($attributes['password']);
			}
			$result = UserRepositoryEloquent::update($attributes, decodeId($id, $this->module));
			if ($result) {
				// 更新用户角色关系
				if (isset($attributes['role']) && $attributes['role']) {
					$result->roles()->sync($attributes['role']);
				}else{
					$result->roles()->sync([]);
				}
				// 更新用户权限关系
				if (isset($attributes['permission']) && $attributes['permission']) {
					$result->userPermissions()->sync($attributes['permission']);
				}else{
					$result->userPermissions()->sync([]);
				}
			}
			flash_info($result,trans('common.edit_success'),trans('common.edit_error'));
			return $this->indexRoute;
		} catch (Exception $e) {
			flash(trans('common.edit_error'), 'danger');
			return $this->indexRoute;
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
			$result = UserRepositoryEloquent::delete(decodeId($id, $this->module));
			flash_info($result,trans('common.destroy_success'),trans('common.destroy_error'));
		} catch (Exception $e) {
			flash(trans('common.destroy_error'), 'danger');
		}
	}

}