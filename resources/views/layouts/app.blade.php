<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.web_name', 'M-finder') }} - {{ config('app.web_title', 'M-finder') }}</title>
        <script src="{{ asset('js/layui/layui.js') }}"></script>
        <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
        <link rel="icon" href="{{ asset('/favicon.ico')}}">
    </head>
    <body>
        <div class="layui-layout layui-layout-admin">
            <div class="layui-header ">
                <div class="layui-logo">
                    <a class="navbar-brand" href="{{ url('/') }}">M-finder</a>
                </div>
            </div>

            <div id="blog-main" class=" content-area container login-content" style="width:100%">
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
            </div>
        </footer>
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
