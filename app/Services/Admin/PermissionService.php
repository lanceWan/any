<?php
namespace App\Services\Admin;

use Facades\ {
    App\Repositories\Eloquent\PermissionRepositoryEloquent,
    Yajra\Datatables\Html\Builder
};

use Datatables;

use Exception;

class PermissionService {

	protected $encrypt = 'permission';

	protected $indexRoute = 'permission.index';

	protected $createRoute = 'permission.create';

	protected $editRoute = 'permission.edit';

	protected $destroyRoute = 'permission.destroy';

	/**
	 * 权限首页
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
		return Datatables::of(PermissionRepositoryEloquent::all())
			->addIndexColumn()
			->addColumn('action', function ($permission)
			{
				
				// 配置按钮权限，目前写死，还没想到好的方案
				$connection = $this->encrypt;
				$encodeId = encodeId($permission->id, $this->encrypt);
				$route = [
					'edit' => route($this->editRoute, [$encodeId]),
					'destroy' => route($this->destroyRoute, [$encodeId]),
				];
				return view(getThemeView('datatables.action'))->with(compact('route', 'connection'))->render();
			})
			->make(true);
	}

	public function attributesButton($permission)
	{
		# code...
	}

	/**
	 * 添加权限
	 * @Author   晚黎
	 * @DateTime 2017-07-26T22:42:59+0800
	 * @param    [type]                   $attributes [description]
	 * @return   [type]                               [description]
	 */
	public function store($attributes)
	{
		try {
			$result = PermissionRepositoryEloquent::create($attributes);
			flash_info($result,trans('common.create_success'),trans('common.create_error'));
			return isset($attributes['rediret']) ? $this->indexRoute : $this->createRoute;
		} catch (Exception $e) {
			return $this->createRoute;
		}
	}
	/**
	 * 修改权限
	 * @author 晚黎
	 * @date   2017-07-27T10:44:41+0800
	 * @param  [type]                   $id [description]
	 * @return [type]                       [description]
	 */
	public function edit($id)
	{
		try {
			$permission = PermissionRepositoryEloquent::find(decodeId($id, $this->encrypt));
			return compact('permission');
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
			$result = PermissionRepositoryEloquent::update($attributes, decodeId($id, $this->encrypt));
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
			$result = PermissionRepositoryEloquent::delete($attributes, decodeId($id, $this->encrypt));
			flash_info($result,trans('common.destroy_success'),trans('common.destroy_error'));
			return $result ? $this->indexRoute : $this->destroyRoute;
		} catch (Exception $e) {
			flash(trans('common.destroy_error'), 'danger');
			return $this->destroyRoute;
		}
	}

}