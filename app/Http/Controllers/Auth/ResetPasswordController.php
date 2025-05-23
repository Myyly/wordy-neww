<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    public function reset(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed',
            ], [
                'password.confirmed' => 'Mật khẩu xác nhận không chính xác.',
                'password.required' => 'Vui lòng nhập mật khẩu mới.',
            ]);
    
            $validator->validate();
        } catch (ValidationException $e) {
            $errorMessage = collect($e->errors())->first()[0];
            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );
    
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công!')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
