<?php
namespace App\Traits;

trait DatatableActionButtonTrait {


	/**
	 * 修改按钮
	 * @Author   晚黎
	 * @DateTime 2017-07-28T20:36:43+0800
	 * @param    [type]                   $id [description]
	 * @return   [type]                       [description]
	 */
	private function getEditActionButton($id)
	{
		if (haspermission($this->module.'controller.edit')) {
			$url = route($this->module.'.edit', [encodeId($id, $this->module)]);
			$edit = trans('common.edit');
			return <<<Eof
				<a href="{$url}" class="btn btn-xs btn-outline btn-warning tooltips" data-original-title="{$edit}" data-placement="top">
					<i class="fa fa-edit"></i>
				</a>
Eof;
		}
		return '';
	}

	/**
	 * 删除按钮
	 * @Author   晚黎
	 * @DateTime 2017-07-28T20:46:15+0800
	 * @param    [type]                   $id [description]
	 * @return   [type]                       [description]
	 */
	private function getDestroyActionButton($id)
	{
		if (haspermission($this->module.'controller.destroy')) {
			$url = route($this->module.'.destroy', [encodeId($id, $this->module)]);
			$delete = trans('common.delete');
			$csrfToken = csrf_field();
			$method = method_field('delete');
			return <<<Eof
				<a href="javascript:;" onclick="return false" class="btn btn-xs btn-outline btn-danger tooltips destroy_item" data-original-title="{$delete}"  data-placement="top">
					<i class="fa fa-trash"></i>
					<form action="{$url}" method="POST" style="display:none">
						$csrfToken
						$method
					</form>
				</a>
Eof;
		}
		return '';
	}


	public function getActionButtonAttribute($id)
	{
		return $this->getEditActionButton($id)
				.$this->getDestroyActionButton($id);
	}
} 