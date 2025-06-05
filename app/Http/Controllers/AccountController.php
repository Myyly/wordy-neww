<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Laravel\File\UploadedFile;
use Illuminate\Support\Facades\Log;
use Cloudinary\Cloudinary;

class AccountController extends Controller
{
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }
    private function getCloudinaryInstance()
    {
        return new Cloudinary([
            'cloud' => [
                'cloud_name' => 'dnrsmozkt',
                'api_key'    => '816326151464958',
                'api_secret' => 'Fmq7-MRf94K1qJT8kKsMZhBElTI',
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }
    public function index()
    {
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
    public function uploadAvatar(Request $request)
    {
        Log::info('Bắt đầu upload avatar lên Cloudinary');
    
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $image = $request->file('avatar');
        $tempPath = $image->getRealPath();
    
        try {
            $cloudinary = $this->getCloudinaryInstance();
    
            $uploadResult = $cloudinary->uploadApi()->upload($tempPath, [
                'folder' => 'avatars/user_' . auth()->id(),
                'public_id' => 'avatar',
                'overwrite' => true,
            ]);
    
            $url = $uploadResult['secure_url'];
    
            $user = auth()->user();
            $user->avatar_img = $url;
            $user->save();
    
            Log::info('Upload thành công', ['url' => $url]);
            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            Log::error('Upload avatar lỗi', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Upload thất bại: ' . $e->getMessage()], 500);
        }
    }
    public function uploadCover(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $image = $request->file('cover');
        $tempPath = $image->getRealPath();
    
        try {
            $cloudinary = $this->getCloudinaryInstance();
    
            $uploadResult = $cloudinary->uploadApi()->upload($tempPath, [
                'folder' => 'covers/user_' . auth()->id(),
                'public_id' => 'cover',
                'overwrite' => true,
            ]);
    
            $url = $uploadResult['secure_url'];
    
            $user = auth()->user();
            $user->cover_img = $url;
            $user->save();
    
            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Upload thất bại: ' . $e->getMessage()], 500);
        }
    }
}
