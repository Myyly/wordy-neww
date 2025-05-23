
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></head>
    <title>Document</title>
</head>
<style>
    * {
    margin: 0;
    padding: 0;
}
.header {
    width: 100%;
    height: 10vh;
    background-color: rgb(255, 180, 5);
}
.footer{
    width: 100%;
    height: 10vh;
    background-color: rgb(255, 180, 5);
   
}
.container{
    width: 100% ;
    height: 80vh;
    background-color: rgb(255, 238, 198);
    overflow: auto;
}
.container-fluid {
    background-color: rgb(255, 238, 198);
    height: 80vh;
    overflow: auto;
}
</style>
<body>
    @include('layouts.header')
    <main class="container-fluid px-0">
        @yield('content')
        @stack('scripts')
        @yield('scripts')
    </main>
    @include('layouts.footer')
</body>
</html>