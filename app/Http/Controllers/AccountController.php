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
    // public function uploadAvatar(Request $request)
    // {
    //     \Illuminate\Support\Facades\Log::info('Bắt đầu upload ảnh');

    //     $request->validate([
    //         'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $image = $request->file('avatar');
    //     $filename = 'avatar_' . auth()->id() . '.' . $image->getClientOriginalExtension();
    //     $folder = 'avatars';
    //     $path = $folder . '/' . $filename;

    //     $fullFolderPath = public_path($folder);
    //     if (!file_exists($fullFolderPath)) {
    //         mkdir($fullFolderPath, 0755, true);
    //          \Illuminate\Support\Facades\Log::info('Đã tạo thư mục avatars tại: ' . $fullFolderPath);
    //     }
    //      \Illuminate\Support\Facades\Log::info('Tên ảnh: ' . $path, ['userId' => auth()->id()]);

    //     $image->move($fullFolderPath, $filename);
    //     $user = auth()->user();
    //     $user->avatar_img = $path;
    //     $user->save();
    //     return response()->json(['path' => $path]);
    // }
    public function uploadAvatar(Request $request)
{
    Log::info('Bắt đầu upload avatar lên Cloudinary');

    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $image = $request->file('avatar');
    $tempPath = $image->getRealPath();

    try {
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => 'dnrsmozkt',
                'api_key'    => '816326151464958',
                'api_secret' => 'Fmq7-MRf94K1qJT8kKsMZhBElTI',
            ],
            'url' => [
                'secure' => true
            ]
        ]);

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
        $filename = 'cover_' . auth()->id() . '.' . $image->getClientOriginalExtension();
        $folder = 'covers';
        $path = $folder . '/' . $filename;

        $fullFolderPath = public_path($folder);
        if (!file_exists($fullFolderPath)) {
            mkdir($fullFolderPath, 0755, true); // recursive = true
            // \Illuminate\Support\Facades\Log::info('Đã tạo thư mục covers tại: ' . $fullFolderPath);
        }

        // \Illuminate\Support\Facades\Log::info('Tên ảnh: ' . $path, ['userId' => auth()->id()]);
        $image->move($fullFolderPath, $filename);
        $user = auth()->user();
        $user->cover_img = $path;
        $user->save();

        return response()->json(['path' => $path]);
    }
}
