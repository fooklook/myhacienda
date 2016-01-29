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
        <div class="logo">
            <div><a href="#" class="logo-name">FOOKLOOK</a></div>
            <div class="logo-motto">只为一点点不平凡</div>
        </div>
        <div class="input-box">
            <div class="button-group">
                <a class="login-button onclick" href="javascript:void(0);">登录</a>
                <a class="register-button" href="javascript:void(0);">注册</a>
            </div>
            <?php
            //获取错误信息
            if(isset($errors)){
                $remind = $errors->all();
            }
            ?>
            <div class="login-box box-container">
                <form role="form" method="post" action="{{ url('/auth/login') }}" name="login">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="group-input">
                        <input class="input-in" type="email" name="user_email" value="{{ isset($remind['login'])?$user_email:"" }}" placeholder="邮箱地址" />
                    </div>
                    <div class="group-input">
                        <input class="input-in" type="password" name="user_password" value="{{ isset($remind['login'])?$user_password:"" }}" placeholder="密码" />
                        <a class="eye a-fa-eye" href="javascript:void(0);"><i class="fa fa-eye"></i></a>
                        <a class="eye a-fa-eye-slash" href="javascript:void(0);" style="display:none;"><i class="fa fa-eye-slash"></i></a>
                    </div>
                    <div class="group-input errors">
                        @if(isset($remind['login']))
                            {{ $remind['login'] }}
                        @endif
                    </div>
                    <div class="group-button"><input type="submit" value="登录" name="submit_button" /></div>
                    <div class="group-input"><input type="checkbox" name="remember" />记住密码 <span class="forget"><a href="javascript:void(0);">忘记密码</a></span></div>
                </form>
            </div>
            <div class="register-box box-container" style="display:none;">
                <form role="form" method="post" action="{{ url('/auth/register') }}" name="register">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="group-input">
                        <input class="input-in" type="email" name="user_email" value="{{ isset($remind['register'])?$user_email:"" }}" placeholder="注册邮箱地址" />
                    </div>
                    <div class="group-input">
                        <input class="input-in" type="password" name="user_password" value="{{ isset($remind['register'])?$user_password:"" }}" placeholder="注册密码" />
                        <a class="eye a-fa-eye" href="javascript:void(0);"><i class="fa fa-eye"></i></a>
                        <a class="eye a-fa-eye-slash" href="javascript:void(0);" style="display:none;"><i class="fa fa-eye-slash"></i></a>
                    </div>
                    <div class="group-input errors">
                        @if(isset($remind['register']))
                            {{ $remind['register'] }}
                        @endif
                    </div>
                    <div class="group-code">
                        <input class="input-in" type="password" name="authcode" placeholder="验证码" />
                        <span id="auth-code" class="refresh"><span class="fa fa-refresh"></span><img src="{{ url('auth/authcode') }}" /></span>
                    </div>
                    <div class="group-button"><input type="submit" value="注册" /></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Swiper JS -->
<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/swiper/swiper-3.3.0.jquery.min.js') }}"></script>

<!-- Initialize Swiper -->
<script>
    $(function(){
        //切换登录与注册
        $(".button-group a").click(function(){
            $(this).addClass('onclick').siblings().removeClass('onclick');
            $(".box-container").hide();
            $(".box-container:eq("+$(this).index()+")").show();
        });
        //显示密码
        $("a.a-fa-eye").click(function(){
            $(this).hide().siblings("a").show();
            $(this).siblings("input").attr('type','text');
        });
        //隐藏密码
        $("a.a-fa-eye-slash").click(function(){
            $(this).hide().siblings("a").show();
            $(this).siblings("input").attr('type','password');
        });
        //点击获取验证码
        $("#auth-code").click(function(){
            $(this).find('img').attr('src',$(this).find('img').attr('src')+"?code="+Math.random());
        });
        //判断显示，如果.errors存在内容，则该内框显示。
        var index = 0;
        $(".errors").each(function(){
            if($.trim($(this).text()) != ""){
                $(".button-group a:eq("+index+")").trigger("click");
            }
            index++;
        });
    });
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay: 5000,//可选选项，自动滑动
        loop : true,
    });
</script>
</body>
</html>