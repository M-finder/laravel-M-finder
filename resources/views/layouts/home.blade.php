<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="{{ $web_info->web_keywords }}"/>
        <meta name="description" content="{{ $web_info->web_description }}"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $web_info->web_name }} - {{ $web_info->web_title }} -  {{ $art->menu or '' }} {{ $article->title or '' }} {{ $page['name'] or '' }}</title>
        <script src="{{ asset('js/layui/layui.js') }}"></script>
        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/common.js') }}"></script>
        <script src="{{ asset('js/home.js') }}"></script>
        <script src="{{ asset('js/musicplayer.js') }}"></script>
        <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
        <link href="{{ asset('css/global.css') }}" rel="stylesheet">
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
                                <a class="logout-btn"  href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出</a>
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

        <div class="main layui-clear ">
            @yield('content')
        </div>        
        @extends('home.footer') 



