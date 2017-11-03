<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    @stack('css')
    <title>Document</title>
</head>
<body>

{{-- 글로벌 헤더--}}
@include('include/global_header')

{{-- 유동 섹션 --}}
<div class="container">
    @yield('content')
</div>


<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
@stack('js')

</body>
</html>