<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="account-container height-100vh">
        <div class="account-box width-500">
            <h2>Đổi mật khẩu</h2>

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
            <form action="{{ route('password.confirm') }}" method="POST">
                @csrf
                <div class="textbox mb-3 password-toggle">
                    <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Mật khẩu hiện tại" value="{{ old('current_password') }}">
                    <i class="fa fa-eye" onclick="togglePassword('current_password', this)"></i>
                </div>
                <div class="textbox mb-3 password-toggle">
                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Mật khẩu mới" value="{{ old('new_password') }}">
                    <i class="fa fa-eye" onclick="togglePassword('new_password', this)"></i>
                </div>
                <div class="textbox mb-3">
                    <input type="text" name="new_password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu mới">
                </div>
                <button type="submit" class="btn btn-primary w-100">Cập nhật mật khẩu</button>
            </form>
            <p class="register-link mt-3">
                <a href="{{ route('list-word') }}">Trở về</a>
            </p>
        </div>
    </div>
</body>
</html>
<script src="{{ asset('js/account.js') }}"></script>
