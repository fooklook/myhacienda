@extends('blog.layout')

@section('title',$article->article_title)
@endsection

@section('pagecss')

@endsection

@section('pagejs')
<script type="text/javascript" src="{{ asset('js/marked.min.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $(".blog-view-container").html(marked($(".blog-view-container").html()));
    });
</script>
@endsection
@section('content')
<div class="container">
    <div class="blog-view-header">
        <a class="home" title="首页" href="#"><span class="glyphicon glyphicon-home"></span>&nbsp;<span class="home-font">返回首页</span></a>
        <hr/>
        <div class="homelogo">
            <nav id="blog-nav">
                <ul class="col-md-12">
                    @foreach($classifys AS $classify_item)
                        <li class="col-md-2 col-xs-4
                    @if($classify_item->article_classify_id == $classify->article_classify_id)
                                click
                        @endif
                                "><a href="{{ url("blog/{$classify_item->article_classify_path}") }}"> <img class="logo-main" src="{{ $classify_item->article_classify_cover }}"></a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
    <div class="blog-view-container">
        {!! $article->article_content !!}
    </div>
</div><!-- /.container -->
@endsection