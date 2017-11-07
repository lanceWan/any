<?php
namespace App\Repositories\Presenters\Admin;

class RolePresenter {
	
	/**
	 * 角色权限列表
	 * @author 晚黎
	 * @date   2017-11-06
	 * @param  [type]     $permissions     [description]
	 * @param  array      $rolePermissions [description]
	 * @return [type]                      [description]
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
	 * @author 晚黎
	 * @date   2017-11-06
	 * @param  [type]     $permissionId    [description]
	 * @param  array      $rolePermissions [description]
	 * @return [type]                      [description]
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
	/**
	 * 查看用户角色权限时展示的table
	 * @author 晚黎
	 * @date   2017-11-06
	 * @param  [type]     $rolePermissions [description]
	 * @return [type]                      [description]
	 */
	public function showRolePermissions($rolePermissions)
	{
		$html = '';
		if (!$rolePermissions->isEmpty()) {
			// 将角色权限分组
			$permissionArray = [];
			foreach ($rolePermissions as $v) {
                $temp = explode('.', $v->slug);
                $permissionArray[$temp[0]][] = $v->toArray();
            }
			if ($permissionArray) {
				foreach ($permissionArray as $key => $permission) {
					$html .= "<tr><td>".$key."</td><td>";
					if (is_array($permission)) {
						foreach ($permission as $k => $v) {
							$html .= <<<Eof
							<div class="col-md-4">
	                        	<label> {$v['name']} </label>
	                      	</div>
Eof;
						}
					}
					$html .= '</td></tr>';
				}
			}
		}
		return $html;
	}
}