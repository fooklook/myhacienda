<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>注册/登录-Fooklook</title>
    <link href="{{ asset('assets/swiper/swiper-3.3.0.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/fontawesome4.2.0/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />
</head>
<body>
<!-- Swiper -->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide" style="background:url(http://7xp3vm.com1.z0.glb.clouddn.com/bg-001.jpg) no-repeat center center"></div>
        <div class="swiper-slide" style="background:url(http://7xp3vm.com1.z0.glb.clouddn.com/bg-001.jpg) no-repeat center center"></div>
        <div class="swiper-slide" style="background:url(http://7xp3vm.com1.z0.glb.clouddn.com/bg-001.jpg) no-repeat center center"></div>
        <div class="swiper-slide" style="background:url(http://7xp3vm.com1.z0.glb.clouddn.com/bg-001.jpg) no-repeat center center"></div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
<div class="main-container">
<div class="main-box">
    <div class="input-box">
        <div class="box-container">
            <p class="remind">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
            </p>
            @if($pattern==1)
            <p class="returnindex"><a href="{{ url('/') }}">返回首页</a></p>
            @elseif($pattern==2)
            <p class="returnindex"><a href="{{ url('auth/login') }}">点击登录/注册</a></p>
            @else
            <p class="returnindex"><a href="{{ url('/') }}">返回首页</a></p>
            @endif
        </div>
    </div>
</div>
</div>

<!-- Swiper JS -->
<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/swiper/swiper-3.3.0.jquery.min.js') }}"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay: 5000,//可选选项，自动滑动
        loop : true,
    });
</script>
</body>
</html>