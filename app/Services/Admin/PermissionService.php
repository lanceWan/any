<?php
namespace App\Services\Admin;

use Facades\ {
    App\Repositories\Eloquent\PermissionRepositoryEloquent,
    Yajra\Datatables\Html\Builder
};

use Datatables;

class PermissionService {

	/**
	 * 权限首页
	 * @Author   晚黎
	 * @DateTime 2017-07-26T22:42:27+0800
	 * @return   [type]                   [description]
	 */
	public function index()
	{
		if (request()->ajax()) {
			return Datatables::of(PermissionRepositoryEloquent::all())
				->addIndexColumn()
				->addColumn('action', getThemeView('datatables.action'))
				->make(true);
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
			return isset($attributes['rediret']) ? 'permission.index':'permission.create';
		} catch (Exception $e) {
			return 'permission.create';
		}
	}

}