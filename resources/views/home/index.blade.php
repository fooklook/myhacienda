@extends('home.layout')

@section('title', '首页')
@endsection
@section('content')
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="http://7xp3vm.com1.z0.glb.clouddn.com/niuniu032400101.jpg" /></div>
        <div class="swiper-slide"><img src="http://7xp3vm.com1.z0.glb.clouddn.com/niuniu032400201.jpg" /></div>
        <div class="swiper-slide"><img src="http://7xp3vm.com1.z0.glb.clouddn.com/niuniu032400301.jpg" /></div>
    </div>
    <div class="swiper-scrollbar"></div>
</div>

<div class="container marketing">
    <div class="row blog-intro">
        @foreach($classifys as $classify)
        <article class="col-md-4">
            <div class="blog-item">
                <div class="blog-img" style="background:url({{ $classify->article_classify_cover }}) center center;"><span class="blog-num">{{ $classify->article_classify_name }}</span></div>
                <p class="blog-msg">
                    {{ $classify->article_classify_describe }}
                </p>
                <div class="blog-append">
                    <div class="blog-click"><span class="glyphicon glyphicon-heart"></span></div>
                    <div class="blog-look"><a href="{{ url('blog/'.$classify->article_classify_path) }}" type="button" class="btn btn-info btn-xs">查看</a></div>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</div><!-- /.container -->
@endsection