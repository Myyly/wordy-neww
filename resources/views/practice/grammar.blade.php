<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue.js Example</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>
<body>
    <div id="app">
        <!-- Dùng @{{ }} để Blade không can thiệp vào Vue -->
        <h1>@{{ title }}</h1>
        <p>@{{ message }}</p>
        <button @click="changeMessage">Nhấn để thay đổi thông điệp</button>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                title: @json($title),
                message: @json($message)
            },
            methods: {
                changeMessage() {
                    this.message = 'Thông điệp đã thay đổi! Bạn đã nhấn nút.';
                }
            }
        });
    </script>
</body>
</html>