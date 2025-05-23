<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    public function sendResetLinkEmail(Request $request)
    {
        // Validate email
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ], [
                'email.required' => 'Vui lòng nhập email.',
                'email.email' => 'Email không đúng định dạng.',
                'email.exists' => 'Email không tồn tại trong hệ thống.',
            ]);
    
            $validator->validate();
    
            // Nếu thành công, tiếp tục xử lý
            // return redirect()->route('some.route');
        } catch (ValidationException $e) {
            $errorMessage = collect($e->errors())->first()[0];
            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
        // Tạo token
        // $token = Str::random(64);

        // // Lưu vào bảng password_resets
        // DB::table('password_resets')->updateOrInsert(
        //     ['email' => $request->email],
        //     [
        //         'token' => $token,
        //         'created_at' => Carbon::now()
        //     ]
        // );

        // // Tạo link reset
        // $resetLink = url('/password/reset/' . $token . '?email=' . urlencode($request->email));
        // // Gửi email
        // Mail::send('auth.passwords.link_change_password', ['resetLink' => $resetLink], function ($message) use ($request) {
        //     $message->to($request->email);
        //     $message->subject('Đặt lại mật khẩu');
        // });

        // return back()->with('success', 'Email đặt lại mật khẩu đã được gửi!');

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', 'Email đặt lại mật khẩu đã được gửi!')
        : back()->withErrors(['email' => __($status)]);
    }
    public function showLinkRequestForm(){
        return view('auth.passwords.email');
    }
    public function showResetForm(){
        return view('auth.passwords.reset');
    }
}
