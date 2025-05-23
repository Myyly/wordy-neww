<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/home';
    protected $account;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        // $this->middleware('auth')->only('logout');
        $this->account = new Account();
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        if (empty($request->email) || empty($request->password)) {
            return redirect()->back()
                ->with('error', 'Thông tin không hợp lệ!')
                ->withInput();
        }

        $user = $this->account->login($request->email, $request->password);

        if (is_null($user)) {
            return redirect()->back()
                ->with('error', 'Email hoặc mật khẩu không đúng!')
                ->withInput();
        }
        Auth::login($user);

        return redirect()->route('list-word')->with('success', 'Đăng nhập thành công!');
    }
}
