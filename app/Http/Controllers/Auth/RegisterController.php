<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        // $this->middleware('guest');
        $this->account = new Account();
    }
    public function showRegistrationForm()
    {
        return view('auth.register');
    } 
   
   public function register(Request $request){
    if ($this->account->emailExists($request->email)) 
    {
        return redirect()->back()->with('error', "Tài khoản đã tồn tại")->withInput();
    } 
    else
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:8',
                'email'    => 'required',
                'full_name' => 'required',
            ], [
                'password.required' => 'Vui lòng nhập mật khẩu.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
                'password.confirmed' => 'Mật khẩu xác nhận không chính xác.',
                'email.required' => 'Vui lòng nhập email.',
            ]);
            $validator->validate();
        } catch (ValidationException $e) {
            $errorMessage = collect($e->errors())->first()[0];
            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
        $user = new User();
        $user->full_name = $request->input('full_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->avatar_img = 'avatars/default.jpg';
        $user->cover_img = 'covers/default.jpg';
        $user->is_verified = 0;
        $user->save();
        $user->sendEmailVerificationNotification();
        return redirect(route('login'))->with('success', 'Đăng ký thành công! Vui lòng xác minh email.');
        
    }
        
}
   
}
