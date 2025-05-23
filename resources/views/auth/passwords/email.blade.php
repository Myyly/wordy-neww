<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="account-container height-100vh">
        <div class="account-box width-500">
            <h2>Quên mật khẩu</h2>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="textbox mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" value="{{ old('email') }}">
                </div>
                <button type="submit" class="btn btn-primary w-100">Gửi liên kết đặt lại mật khẩu</button>
            </form>
            <p class="register-link mt-3">
                <a href="{{ route('login') }}">Quay lại đăng nhập</a>
            </p>
        </div>
    </div>
</body>
</html>