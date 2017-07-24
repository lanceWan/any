<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class HomeController extends BaseController
{

	public function __construct()
	{
		parent::__construct();
	}
    public function index()
    {
    	return view(getThemeView('home.index'));
    }
}
