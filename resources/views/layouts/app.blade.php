<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.web_name', 'M-finder') }} - {{ config('app.web_title', 'M-finder') }}</title>
        <script src="{{ asset('js/layui/layui.js') }}"></script>
        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/common.js') }}"></script>
        <script src="{{ asset('js/home.js') }}"></script>
        <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
        <link href="{{ asset('css/global.css') }}" rel="stylesheet">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
        <link rel="icon" href="http://www.m-finder.com/Public/favicon.ico"> 
    </head>
    <body>
        <div class="layui-layout layui-layout-admin">
            <div class="layui-header">
                <div class="layui-logo">
                    <a class="navbar-brand" href="{{ url('/') }}">M-finder</a>
                </div>
                <ul class="layui-nav layui-layout-right">
                    @if (Auth::guest())
                    <li class="layui-nav-item"><a href="{{ route('register') }}">注册</a></li>
                    <li class="layui-nav-item"><a href="{{ route('login') }}">登录</a></li>
                    @else
                    <li class="layui-nav-item">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endif
<!--                    <li class="layui-nav-item">
                        <a href="javascript:;">
                            <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                            贤心
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a href="">基本资料</a></dd>
                            <dd><a href="">安全设置</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item"><a href="">退了</a></li>-->
                </ul>
            </div>

            <div class="content-area container login-content">
                @yield('content')
            </div>
        </div>

        <footer class="footer">
            <div class="footavatar site-footer clearfix u-textAlignCenter">
                <img src="{{ asset('images/logo.jpg') }}" alt="官方微信二维码" title="扫码关注官方微信，更多资讯抢先获取" class="footphoto">     
                <ul class="footinfo">
                    <p class="fname"><a>{{ config('app.web_name', 'M-finder') }}</a></p>
                    <p class="finfo">{{ config('app.sign', 'M-finder') }}</p>
                </ul>
            </div>
            <div class="Copyright">
                <p>
                    <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=c4f068d3baefa9f0e31f6271d9bebe70e542830dd6e713d7689fd2a084a952e7">
                        <img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="php行业交流" title="php行业交流">
                    </a>
                </p><br>
                Powered by <a href="http://www.m-finder.com" target="_blank">M-finder</a> 
                <img class="music" src="{{ asset('images/music.png') }}">
                <audio id="song" preload="auto" src="http://www.m-finder.com/Public/Home/CityofStars.mp4"></audio>
            </div>
        </footer>
    </body>
</html>
