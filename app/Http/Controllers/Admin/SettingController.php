<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends BaseController
{
	/**
	 * 设置语言
	 * @author 晚黎
	 * @date   2017-08-02T11:28:06+0800
	 * @return [type]                   [description]
	 */
    public function language($lang)
    {
    	session(['locale' => $lang]);
    	return redirect()->back();
    }
}
