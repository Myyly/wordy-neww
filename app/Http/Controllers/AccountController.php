<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
class AccountController extends Controller
{
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

  public function index(){
      $user = auth()->user();
        return view('profile.index')->with('user', $user);
  }
  public function edit_infor(Request $request)
{
    $request->validate([
        'fullName' => 'required|string|max:255',
        'bio' => 'nullable|string|max:1000',
    ]);
    $user = Auth::user();
    $user->full_name = $request->input('fullName');
    $user->bio = $request->input('bio');
    $user->save();
    return redirect()->back()->with('success', 'Cập nhật thông tin thành công.')->withInput();
}
}