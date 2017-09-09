@extends('layouts.app')

@section('content')

<div class="layui-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">重置密码</li>
        <li></li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">

            <form class="layui-form layui-form-pane login-box" method="POST" action="{{ route('password.request') }}" id="login-box">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
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
                    <label class="layui-form-label">重置密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password" id="password" lay-verify="password" autocomplete="off" placeholder="请输入重置密码" class="layui-input" autofocus autocomplete="off">
                    </div>
                    @if ($errors->has('password'))
                    <div class="layui-form-mid layui-word-aux">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">确认密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password_confirmation" id="password-confirm" lay-verify="repassword" autocomplete="off" placeholder="请输入确认密码" class="layui-input" autofocus autocomplete="off">
                    </div>
                    @if ($errors->has('password_confirmation'))
                    <div class="layui-form-mid layui-word-aux">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                    @if (session('status'))
                        <div class="layui-form-mid layui-word-aux">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                <div class="layui-form-item login-btn-box">
                    <button class="layui-btn" lay-submit="" lay-filter="login-box">提交修改</button>
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
            password: [/(.+){6,32}$/, '密码必须6到32位']
            , repassword: function (val) {
                if( val!= $('#password').val()){
                    return '密码输入不一致';
                }
            }
        });
    });
</script>
@endsection
