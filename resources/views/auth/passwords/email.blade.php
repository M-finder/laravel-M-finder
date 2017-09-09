@extends('layouts.app')

@section('content')

<div class="layui-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">忘记密码</li>
        <li></li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">

            <form class="layui-form layui-form-pane login-box" method="POST" action="{{ route('password.email') }}" id="login-box">
                {{ csrf_field() }}

                <div class="layui-form-item ">
                    <label class="layui-form-label">登录邮箱</label>
                    <div class="layui-input-inline">
                        <input id="email" type="text" class="layui-input" lay-verify="require|email" name="email" value="{{ old('email') }}" autofocus autocomplete="off" placeholder="请输入登录邮箱">
                    </div>
                    @if ($errors->has('email'))
                        <div class="layui-form-mid layui-word-aux">{{ $errors->first('email') }}</div>
                    @endif
                    @if (session('status'))
                        <div class="layui-form-mid layui-word-aux">{{ session('status') }}</div>
                    @endif
                </div>

                <div class="layui-form-item login-btn-box">
                    <button class="layui-btn" lay-submit="" lay-filter="login-box">确认提交</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form, layer = layui.layer;
    });
</script>

@endsection
