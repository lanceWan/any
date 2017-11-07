<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['namespace' => 'Auth', 'middleware' => 'language'], function ($router)
{
	$router->get('login', 'LoginController@showLoginForm');
	$router->post('login', 'LoginController@login');
	$router->post('logout', 'LoginController@logout');
});

Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware' => ['auth', 'check.permission', 'language']],function ($router)
{
	$router->get('/','HomeController@index');
	// 权限
	$router->resource('permission','PermissionController');
	// 角色
	$router->resource('role','RoleController');
	// 用户
	$router->resource('user','UserController');
	// 菜单
	$router->get('menu/clear','MenuController@cacheClear');
	$router->resource('menu','MenuController');
	$router->get('setting/{lang}', 'SettingController@language');
});