<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>{{ $web_info->web_name }} - {{ $web_info->web_title }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('js/layui/layui.js') }}"></script>
        <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
        <link rel="icon" href="{{ asset('/favicon.ico')}}"> 
    </head>
    <body>
        <div class="layui-layout layui-layout-admin">
            <div class="layui-header ">
                <div class="layui-logo">
                    <a class="navbar-brand" href="{{ url('/') }}" >{{ $web_info->web_name }}</a>
                </div>
                <ul class="layui-nav layui-layout-left dashboard">
                    <li class="layui-nav-item layui-this"><a href="/admin/dashboard">后台管理</a></li>
                </ul>
                @if (!Auth::guest())
                <ul class="layui-nav layui-layout-right nav-user">
                    <li class="layui-nav-item " >
                        <a href="javascript:;" id="uid" data-uid="{{ Auth::user()->id }}">
                            <img src="{{ isset(Auth::user()->avatar) ? Auth::user()->avatar : '/images/avatar/'.rand(1,11).'.jpg' }} " class="layui-nav-img">
                            {{ Auth::user()->name }}
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a href="/admin/infoset">个人设置</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a  href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
                @endif
            </div>
            <div class="layui-side layui-bg-black">
                <div class="layui-side-scroll">
                    <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                    <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                        <li class="layui-nav-item {{ $url == 'dashboard' ? 'layui-this' : '' }}">
                            <a class="" href="/admin/dashboard">所有文章</a>
                        </li>
                        <li class="layui-nav-item {{ $url == 'comments' ? 'layui-this' : '' }}">
                            <a class="" href="/admin/comments">所有评论</a>
                        </li>
                        <li class="layui-nav-item {{ $url == 'category' ? 'layui-this' : '' }}">
                            <a class="" href="/admin/category">分类管理</a>
                        </li>
                        <li class="layui-nav-item {{ $url == 'users' ? 'layui-this' : '' }}">
                            <a class="" href="/admin/user">用户管理</a>
                        </li>

                        <li class="layui-nav-item {{ $url == 'messages' ? 'layui-this' : '' }}">
                            <a class="" href="/admin/messages">后台消息</a>
                        </li>
                        <li class="layui-nav-item {{ $url == 'infoset' ? 'layui-this' : '' }}">
                            <a class="" href="/admin/infoset">个人设置</a>
                        </li>
                        <li class="layui-nav-item {{ $url == 'links' ? 'layui-this' : '' }}">
                            <a class="" href="/admin/links">友情链接</a>
                        </li>
                        <li class="layui-nav-item {{ $url == 'sysconfig' ? 'layui-this' : '' }}">
                            <a class="" href="/admin/sysconfig">网站设置</a>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="site-tree-mobile layui-hide">
                <i class="layui-icon">&#xe602;</i>
            </div>
            <div class="site-mobile-shade"></div>

            <div class="layui-body" id="layui-body">
                @yield('content')
            </div>

            <div class="layui-footer">
                © {{ $web_info->web_name }} - {{ $web_info->web_title }}
            </div>
        </div>
        
        <script src="{{ asset('js/nprogress.js') }}"></script>
        <script type="text/javascript">
            layui.config({
                base: '/js/'
                ,version: false
            }).extend({
                admin: 'admin',
                pjax:'pjax'
            }).use(['admin','pjax'],function (){
                var $ = layui.jquery;
                $(function () {
                    $(document).pjax('a', '#layui-body');
                   
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



