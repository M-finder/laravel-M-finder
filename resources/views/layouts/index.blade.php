<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="{{ $web_info->web_keywords }}"/>
        <meta name="description" content="{{ $web_info->web_description }}"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $web_info->web_name }} - {{ $web_info->web_title }}</title>
        <script src="{{ asset('js/layui/layui.js') }}"></script>
        <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
        <link rel="icon" href="{{ asset('/favicon.ico')}}">
    </head>
    <body class="home blog ">
        <div class="hfeed site">
            <header id="header" class="home-header blog-background banner-mask">
                <div class="nav-header container">       
                    <div class="nav-header-container" >
                        @foreach($menus as $nav)
                        <a class="back-home" href="{{ $nav['type']== 2  ?  $nav['link'] : ($nav['type']==1 ?  '/home/single-page/'.$nav['id'] : '/home/category/'.$nav['id'])  }}" data-id="{{$nav['id']}}">{{$nav['name']}}</a>
                        @endforeach
                    </div>            
                </div>
                <div class="header-wrap">
                    <div class="container">
                        <div class="home-info-container">
                            <a href="/">
                                <h2>{{ $web_info->web_name }}</h2>
                            </a>
                            <h4 id="web_title_desc">{{ $web_info->web_title }}</h4>
                            @if (Auth::guest())
                            <div class='log-box'>
                                <a class="reg" href="{{ route('register') }}">注册</a>
                                <a class="login" href="{{ route('login') }}">登录</a>
                            </div>
                            @else
                            <li class="dropdown">
                                <a href="/userhome" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    欢迎你，
                                    {{ Auth::user()->name }}
                                </a>
                                <a class="logout-btn"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">退出</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                            @endif
                        </div>
                    </div>
                </div>
            </header>
        </div>

        <div id="blog-main" class="main layui-clear">
            @yield('content')
        </div>        
        <div class="site-footer clearfix u-textAlignCenter footer-link ">
            @if(count($links)>0)
            友情链接：
            <span class="layui-breadcrumb" lay-separator="|" style="visibility: visible;">
                @foreach($links as $link)
                <a href="{{$link['link']}}"  target="_blank" >{{ $link['name'] }}</a>
                @endforeach
            </span>
            @endif
        </div>
        <footer class="footer">
            <div class="footavatar site-footer clearfix u-textAlignCenter">
                <img src="{{ asset($web_info->web_logo) }}" alt="logo" title="{{ $web_info->web_logo_description }}" class="footphoto">     
                <ul class="footinfo">
                    <p class="fname"><a>{{ $web_info->web_name }}</a></p>
                    <p class="finfo">{{ $web_info->web_title }}</p>
                </ul>
            </div>
            <div class="Copyright">
                <p>
                    <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=c4f068d3baefa9f0e31f6271d9bebe70e542830dd6e713d7689fd2a084a952e7">
                        <img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="php行业交流" title="php行业交流">
                    </a>
                </p><br>
                Powered by <a href="http://www.m-finder.com" target="_blank">M-finder</a> 
            </div>
        </footer>
        <script id="comment_tpl" type="text/html">
            @{{# for(var i = 0; i < d.data.length; i++){ }}
            <li class="comment even thread-even depth-1">
                <article class="comment-body" id="comment">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <img src="@{{ d.data[i].avatar===null ? '/images/avatar/'+parseInt(11*Math.random()) +'.jpg' : d.data[i].avatar }}" width="64" height="64" alt="@{{ d.data[i].name }}" class="avatar avatar-42 wp-user-avatar wp-user-avatar-42 alignnone photo" />                    						
                            <b class="fn">@{{ d.data[i].name }}</b><span class="says">：</span>					
                        </div>
                        <div class="comment-metadata">
                            <time datetime="@{{ d.data[i].creted_at }}"> @{{ layui.util.timeAgo(d.data[i].created_at) }} </time>
                        </div>
                    </footer>
                    <div class="comment-content photos">
                        @{{ d.data[i].content }}
                    </div>
                    <div class="reply">
                        <a rel="nofollow" class="comment-reply-link" href="javascript:void(0)" data-uid="@{{ d.data[i].uid }}" data-name="@{{ d.data[i].name }}">回复</a>
                    </div>
                </article>
            </li>
            @{{# } }}
        </script>
        <script src="{{ asset('js/nprogress.js') }}"></script>
        <script type="text/javascript">
            layui.config({
                base: '/js/'
                ,version: false
            }).extend({
                home: 'home',
                pjax:'pjax'
            }).use(['home','pjax'],function (){
                var $ = layui.jquery;
                $(function () {
                    $(document).pjax('a', '#blog-main');
                    $(document).on('pjax:start', function () {
                        NProgress.start();
                    });
                    $(document).on('pjax:end', function () {
                        NProgress.done();
                    });
                   
                });
            });
        </script>
    </body>
</html>

