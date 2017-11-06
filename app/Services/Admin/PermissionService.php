<?php
namespace App\Services\Admin;

use Facades\ {
    App\Repositories\Eloquent\PermissionRepository,
    Yajra\DataTables\Html\Builder
};

use App\Repositories\Traits\DatatableActionButtonTrait;

use DataTables;
use Exception;

class PermissionService {
	use DatatableActionButtonTrait;

	protected $module = 'permission';
	protected $indexRoute = 'permission.index';
	protected $createRoute = 'permission.create';
	protected $editRoute = 'permission.edit';
	protected $destroyRoute = 'permission.destroy';
	/**
	 * 权限首页
	 * @author 晚黎
	 * @date   2017-11-06
	 * @return [type]     [description]
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
	 * @date   2017-11-06
	 * @return [type]     [description]
	 */
	public function ajaxData()
	{
		return Datatables::of(PermissionRepository::all())
			->addIndexColumn()
			->addColumn('action', function ($permission)
			{
				return $this->getActionButtonAttribute($permission->id);
			})
			->make(true);
	}
	/**
	 * 添加权限
	 * @author 晚黎
	 * @date   2017-11-06
	 * @param  [type]     $attributes [description]
	 * @return [type]                 [description]
	 */
	public function store($attributes)
	{
		try {
			$result = PermissionRepository::create($attributes);
			flash_info($result,trans('common.create_success'),trans('common.create_error'));
			return isset($attributes['rediret']) ? $this->createRoute : $this->indexRoute;
		} catch (Exception $e) {
			return $this->createRoute;
		}
	}
	/**
	 * 修改权限
	 * @author 晚黎
	 * @date   2017-11-06
	 * @param  [type]     $id [description]
	 * @return [type]         [description]
	 */
	public function edit($id)
	{
		try {
			$permission = PermissionRepository::find(decodeId($id, $this->module));
			return compact('permission');
		} catch (Exception $e) {
			flash(trans('common.find_error'), 'danger');
			return redirect()->route($this->indexRoute);
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
			$result = PermissionRepository::update($attributes, decodeId($id, $this->module));
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
	 * @date   2017-11-06
	 * @param  [type]     $id [description]
	 * @return [type]         [description]
	 */
	public function destroy($id)
	{
		try {
			$result = PermissionRepository::delete(decodeId($id, $this->module));
			flash_info($result,trans('common.destroy_success'),trans('common.destroy_error'));
		} catch (Exception $e) {
			flash(trans('common.destroy_error'), 'danger');
		}
	}
}