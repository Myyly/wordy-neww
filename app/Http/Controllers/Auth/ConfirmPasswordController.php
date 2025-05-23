<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showConfirmForm(){
        return view('auth.passwords.confirm');
    }
    public function confirm(Request $request){
        $user = auth()->user();

        try {
            $validator = Validator::make($request->all(), [
                'new_password' => 'required|confirmed',
            ], [
                'new_password.confirmed' => 'Mật khẩu xác nhận không chính xác.',
                'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            ]);

            $validator->validate();
        } catch (ValidationException $e) {
            $errorMessage = collect($e->errors())->first()[0];
            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
        $old_pass = $request->input('current_password');
        $new_pass = $request->input('new_password');
        if (!Hash::check($old_pass, $user->password)) {
            return redirect()->back()
                ->with('error', 'Mật khẩu hiện tại không chính xác!')
                ->withInput();
        }
        $user->password = Hash::make($new_pass);
         $user->save();
        return redirect(route('list-word'))->with('success',"Đổi mật khẩu thành công");
    }
}
