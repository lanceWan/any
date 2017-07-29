<?php
namespace App\Presenters\Admin;

class RolePresenter
{
	/**
	 * 角色权限列表
	 * @Author   晚黎
	 * @DateTime 2017-07-29T11:55:49+0800
	 * @param    [type]                   $permissions     [description]
	 * @param    array                    $rolePermissions [description]
	 * @return   [type]                                    [description]
	 */
	public function permissionList($permissions,$rolePermissions=[])
	{
		$html = '';
		if ($permissions) {
			foreach ($permissions as $key => $permission) {
				$html .= "<tr><td>".$key."</td><td>";
				if (is_array($permission)) {
					foreach ($permission as $k => $v) {
						$html .= <<<Eof
						<div class="col-md-4">
	                     	<div class="i-checks">
	                        	<label> <input type="checkbox" name="permission[]" {$this->checkPermisison($v['id'],$rolePermissions)} value="{$v['id']}"> <i></i> {$v['name']} </label>
	                      	</div>
                      	</div>
Eof;
					}
				}
				$html .= '</td></tr>';
			}
		}
		return $html;
	}

	/**
	 * 添加修改角色出现错误时，获取已经填写的权限
	 * @Author   晚黎
	 * @DateTime 2017-07-29T11:56:02+0800
	 * @param    [type]                   $permissionId    [description]
	 * @param    array                    $rolePermissions [description]
	 * @return   [type]                                    [description]
	 */
	private function checkPermisison($permissionId,$rolePermissions = [])
	{
		$permissions = old('permission');
		if ($permissions) {
			return in_array($permissionId,$permissions) ? 'checked="checked"':'';
		}
		if ($rolePermissions) {
			if ($permissions) {
				if (in_array($permissionId,$rolePermissions) && in_array($permissionId,$permissions)) {
					return 'checked="checked"';
				}
			}else{
				return in_array($permissionId,$rolePermissions) ? 'checked="checked"':'';
			}
			return '';
		}
		return '';
	}
}