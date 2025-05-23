<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Account extends Model
{
    use HasFactory;
    public $timestamps = false; 
    protected $table = 'flashcards';
    protected $primaryKey = 'id';

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'avatar_img',
        'cover_img',
        'bio',
        'is_verified'
    ];
    public function login($email,$password){
        $user = User::where('email', $email)->first();
    
    if ($user && Hash::check($password, $user->password)) {
        return $user; // Trả về model Eloquent
    }

    return null;
    }
    public function emailExists($email)
{
    return DB::table('users')->where('email', $email)->exists();
}
public function updatePassword()
{
    return DB::table('users')
        ->where('email', "myylyy1@gmail.com")
        ->update(['password' => Hash::make("123")]);
}

}
