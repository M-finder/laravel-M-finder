@extends('layouts.app')

@section('content')
<div class="layui-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">登录</li>
        <li></li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">

            <form class="layui-form layui-form-pane login-box" method="POST" action="{{ route('login') }}" id="login-box">
                {{ csrf_field() }}
                <div class="layui-form-item ">
                    <label class="layui-form-label">登录邮箱</label>
                    <div class="layui-input-inline">
                        <input id="email" type="email" class="layui-input" lay-verify="require|email" name="email" value="{{ old('email') }}" autofocus autocomplete="off" placeholder="请输入登录邮箱">
                    </div>
                    @if ($errors->has('email'))
                    <div class="layui-form-mid layui-word-aux">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">登录密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password" lay-verify="password" autocomplete="off" placeholder="请输入登录密码" class="layui-input" autofocus autocomplete="off">
                    </div>
                    @if ($errors->has('password'))
                    <div class="layui-form-mid layui-word-aux">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="layui-form-item login-btn-box">
                    <button class="layui-btn" lay-submit="" lay-filter="login-box">立即登录</button>
                    <span style="padding-left:20px;"><a href="{{ route('password.request') }}">忘记密码？</a></span>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form, layer = layui.layer;
        //自定义验证规则
        form.verify({
            password: [/(.+){6,12}$/, '密码必须6到12位']
        });
    });
</script>

@endsection
