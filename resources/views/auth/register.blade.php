@extends('layouts.app')

@section('content')
<div class="layui-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">注册</li>
        <li></li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">

            <form class="layui-form layui-form-pane login-box" method="POST" action="{{ route('register') }}" id="login-box">
                {{ csrf_field() }}
                <div class="layui-form-item ">
                    <label class="layui-form-label">用户名称</label>
                    <div class="layui-input-inline">
                        <input id="name" type="text" class="layui-input" lay-verify="require|name" name="name" value="{{ old('name') }}" autofocus autocomplete="off" placeholder="请输入用户名称">
                    </div>
                    @if ($errors->has('name'))
                    <div class="layui-form-mid layui-word-aux">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="layui-form-item ">
                    <label class="layui-form-label">登录邮箱</label>
                    <div class="layui-input-inline">
                        <input id="email" type="text" class="layui-input" lay-verify="require|email" name="email" value="{{ old('email') }}" autofocus autocomplete="off" placeholder="请输入登录邮箱">
                    </div>
                    @if ($errors->has('email'))
                    <div class="layui-form-mid layui-word-aux">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">登录密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password" id="password" lay-verify="password" autocomplete="off" placeholder="请输入登录密码" class="layui-input" autofocus autocomplete="off">
                    </div>
                    @if ($errors->has('password'))
                    <div class="layui-form-mid layui-word-aux">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="layui-form-item login-btn-box">
                    <button class="layui-btn" lay-submit="" lay-filter="login-box">提交注册</button>
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
            name: function (val) {
                if (val === '' || $.trim(val).length == 0 || $.trim(val).length < 2 || $.trim(val).length > 20) {
                    return '用户名长度2-20';
                }
                if (!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(val)) {
                    return '用户名不能有特殊字符';
                }
                if (/(^\_)|(\__)|(\_+$)/.test(val)) {
                    return '用户名首尾不能出现下划线\'_\'';
                }
                if (/^\d+\d+\d$/.test(val)) {
                    return '用户名不能全为数字';
                }
            }
            , password: [/(.+){6,32}$/, '密码必须6到32位']
        });
    });
</script>

@endsection
