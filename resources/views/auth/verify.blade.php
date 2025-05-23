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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: rgb(255, 238, 198);
            color: rgb(144, 100, 0);
            font-family: Arial, sans-serif;
        }

        .custom-notice {
            background-color: #fff8dc;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 5px solid rgb(255, 180, 5);
        }

        .custom-success {
            background-color: #d4edda;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 5px solid green;
        }

        .action-bar button,
        .main-container button {
            background-color: rgb(255, 180, 5);
            border: none;
            width: 100px;
            height: 30px;
            border-radius: 5px;
            font-size: 14px;
            color: rgb(144, 100, 0);
            font-weight: bold;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .action-bar button:hover,
        .main-container button:hover {
            background-color: rgb(255, 238, 198);
        }

        .container {
            margin-top: 50px;
            max-width: 500px;
        }
    </style>
</head>
<body>
<div class="container">
    @if (session('resent'))
        <div class="custom-success">
            Liên kết xác minh mới đã được gửi đến email của bạn.
        </div>
    @endif

    <div class="custom-notice">
        Vui lòng kiểm tra email của bạn để xác minh tài khoản.<br>
        Nếu bạn chưa nhận được email, hãy nhấn vào nút dưới đây để gửi lại:
    </div>

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <div class="action-bar">
            <button type="submit">Gửi lại</button>
        </div>
    </form>
</div>
</body>
</html>