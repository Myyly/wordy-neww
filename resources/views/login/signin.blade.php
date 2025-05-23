<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="account-container height-100vh">
        <div class="account-box width-500">
            <h2>Đăng ký</h2>
            <form action="{{route('sign_in')}}" method="POST">
                @csrf
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif
                <div class="textbox">
                    <input type="text" placeholder="Họ và tên" name="full_name"  value ="{{old('full_name')}}">
                </div>
                <div class="textbox">
                    <input type="email" placeholder="Email" name="email" value="{{old('email')}}">
                </div>
                <div class="textbox mb-3 password-toggle">
                    <input type="password" placeholder="Mật khẩu" name="password" id="password" value="{{old('password')}}">
                    <i class="fa fa-eye" onclick="togglePassword('password', this)"></i>
                </div>
                <div class="textbox">
                    <input type="text" placeholder="Nhập lại mật khẩu" name="password_confirmation" value="{{old('password_confirmation')}}">
                </div>
                <button type="submit" class="btn">Đăng ký</button>
                <p class="register-link">Đã có tài khoản? <a href="{{route('login')}}">Đăng nhập</a></p>
            </form>
        </div>
    </div>
</body>
</html>
 <script src="{{ asset('js/account.js') }}"></script>