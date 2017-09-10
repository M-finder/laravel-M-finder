@extends('layouts.app')

@section('content')
<div class="layui-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">后台登录</li>
        <li></li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">

            <form class="layui-form layui-form-pane login-box" method="POST" id="login-box">
                {{ csrf_field() }}
                <div class="layui-form-item ">
                    <label class="layui-form-label">登录名称</label>
                    <div class="layui-input-inline">
                        <input id="name" type="text" class="layui-input" lay-verify="required" name="name" value="{{ old('name') }}" autofocus autocomplete="off" placeholder="请输入登录名称">
                    </div>
                    @if ($errors->has('name'))
                    <div class="layui-form-mid layui-word-aux">{{ $errors->first('name') }}</div>
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
        //事件监听
        form.on('submit(login-box)', function (data) {
            var data = data.field;
            $.post('/admin/login', {data}, function (res) {
                if (res.code == 0) {
                    layer.msg('操作成功', {icon: 1});
                    setTimeout(function () {
                        window.location.href = "/admin/dashboard";
                    }, 2000);
                } else {
                    layer.msg(res.msg, {icon: 5});
                }
                return false;
            });
            return false;
        });

    });
</script>

@endsection
