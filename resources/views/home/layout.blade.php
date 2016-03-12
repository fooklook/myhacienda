<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ����3��meta��ǩ*����*������ǰ�棬�κ��������ݶ�*����*������� -->
    <meta name="description" content="fooklook个人博客网站，记录技术研究笔记、个人想法和个人经验。">
    <meta name="keywords" content="Laravel学堂,php,ubuntu,nginx,apache,jquery,markdown,git,github">
    <meta name="author" content="fooklook">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <title>@yield('title')--Fooklook</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/bootstrap3.0/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/swiper/swiper-3.3.0.min.css') }}" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="{{ asset('js/ie-compat/ie8-responsive-file-warning.js') }}"></script><![endif]-->
    <script src="{{ asset('js/ie-compat/ie-emulation-modes-warning.js') }}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ asset('js/ie-compat/html5shiv.min.js') }}"></script>
    <script src="{{ asset('js/ie-compat/respond.min.js') }}"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<!-- NAVBAR
================================================== -->
<body>
<div class="navbar-wrapper">
    <div class="container">

        <nav class="navbar navbar-blog navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="glyphicon glyphicon-align-justify"></span>
                    </button>
                    <a class="navbar-brand-blog" href="#">Fooklook</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="{{ url('/') }}">首页</a></li>
                        <li><a href="{{ url('blog/laravelnote') }}">个人博客</a></li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>
</div>
@yield('content')

<!-- FOOTER -->
<footer class="container">
    <p>&copy; 2015-2016 By fooklook xiashou.he#foxmail.com 粤ICP备15077021号-1</p>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap3.0/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/swiper/swiper-3.3.0.jquery.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('js/ie-compat/ie10-viewport-bug-workaround.js') }}"></script>
<script src="{{ asset('js/main.js') }}" type="text/JavaScript"></script>
<script type="text/JavaScript">
    var mySwiper = new Swiper('.swiper-container', {
        autoplay: 5000,//��ѡѡ��Զ�����
        scrollbar:'.swiper-scrollbar',
        loop : true,
    })
</script>
@include('analytics_baidu')
</body>
</html>
