<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></head>
    <title>Log in</title>
</head>
<body>
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
          {{ session('success') }}
      </div>
  @endif
 
    <div class="account-container height-100vh">
        <div class="account-box width-500">
            <h2>Đăng nhập</h2>
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-message">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            <form action="{{route('login')}}" method="POST">
                @csrf
                <div class="textbox">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control"placeholder="Nhập email">
                </div>
                <div class="textbox mb-3 password-toggle">
                    <input type="password" placeholder="Mật khẩu" name="password"id="password" value="{{old('password')}}">
                    <i class="fa fa-eye" onclick="togglePassword('password', this)"></i>
                </div>
                <button type="submit" class="btn">Đăng nhập</button>
            </form>
                <p class="register-link">Chưa có tài khoản? <a href="{{route('register')}}">Đăng ký</a></p>
                <p class="register-link"><a href="{{route('password.request')}}">Quên mật khẩu</a></p>
        </div>
    </div>
</body>
</html>
<script src="{{ asset('js/account.js') }}"></script>
