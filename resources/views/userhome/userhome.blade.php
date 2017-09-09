<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>{{ $web_info->web_name }} - {{ $web_info->web_title }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('js/layui/layui.js') }}"></script>
        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/common.js') }}"></script>
        <script src="{{ asset('js/home.js') }}"></script>
        <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
        <link href="{{ asset('css/global.css') }}" rel="stylesheet">
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
                    <li class="layui-nav-item layui-this"><a href="/userhome">控制台</a></li>
                </ul>
                @if (!Auth::guest())
                <ul class="layui-nav layui-layout-right nav-user">
                    <li class="layui-nav-item " >
                        <a href="javascript:;" id="uid" data-uid="{{ Auth::user()->id }}">
                            <img src="/images/avatar/{{ isset(Auth::user()->avatar) ?Auth::user()->avatar :rand(1,11).'.jpg' }} " class="layui-nav-img">
                            {{ Auth::user()->name }}
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a href="/userhome/infoset">基本资料</a></dd>
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
                        <li class="layui-nav-item layui-nav-itemed">
                            <a class="" href="/userhome">所有文章</a>
                        </li>
                        <li class="layui-nav-item layui-nav-itemed">
                            <a class="" href="/userhome/myarticles">我的文章</a>
                        </li>
                        <li class="layui-nav-item layui-nav-itemed">
                            <a class="" href="/userhome/new-article">发表新作</a>
                        </li>
                        <li class="layui-nav-item layui-nav-itemed">
                            <a class="" href="/userhome/messages">我的消息</a>
                        </li>
                        <li class="layui-nav-item layui-nav-itemed">
                            <a class="" href="/userhome/infoset">个人设置</a>
                        </li>
                        <li class="layui-nav-item"><a href="">联系后台</a></li>
                    </ul>

                </div>
            </div>
            <div class="site-tree-mobile layui-hide">
                <i class="layui-icon">&#xe602;</i>
            </div>
            <div class="site-mobile-shade"></div>

            @yield('userhomecontent')

            <div class="layui-footer">
                © {{ $web_info->web_name }} - {{ $web_info->web_title }}
            </div>
        </div>
        <script>
            layui.use('element', function () {
                var element = layui.element;

            });
        </script>
    </body>
</html>



