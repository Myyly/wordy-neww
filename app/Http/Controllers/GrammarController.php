<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GrammarController extends Controller
{
    public function index(){
        $title = 'Tiêu đề lấy từ cơ sở dữ liệu';
        $message = 'Thông điệp lấy từ cơ sở dữ liệu';
    
        return view('practice.grammar', compact('title', 'message'));
    }
}
