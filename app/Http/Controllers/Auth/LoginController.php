<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * 自定义用户名
     * @author 晚黎
     * @date   2017-11-06
     * @return [type]     [description]
     */
    public function username()
    {
        return config('admin.global.username');
    }

    /**
     * 自定义登录视图
     * @author 晚黎
     * @date   2017-11-06
     * @return [type]     [description]
     */
    public function showLoginForm()
    {
        return view('themes.auth.'.getTheme().'.login');
    }
    
    /**
     * 用户登录成功后缓存用户权限
     * @author 晚黎
     * @date   2017-11-06
     * @param  Request    $request [description]
     * @param  [type]     $user    [description]
     * @return [type]              [description]
     */
    protected function authenticated(Request $request, $user)
    {
        // 缓存用户权限
        setUserPermissions($user);
        return redirect()->intended($this->redirectPath());
    }
}
