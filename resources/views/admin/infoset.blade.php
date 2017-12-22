@extends('layouts.admin')

@section('content')

<div style="padding: 15px;overflow: hidden">

    <fieldset class="layui-col-md4 layui-col-xs12 layui-elem-field">
        <legend>安全设置</legend>
        <form class="layui-form layui-form-pane " method="POST" onsubmit="return false" >
            <input type="hidden" name='token' value='{{ $token or '' }}'>
            <div class="layui-form-item " style="margin-left:20px;margin-top:10px;">
                <label class="layui-form-label">原始密码</label>
                <div class="layui-input-inline">
                    <input id="oldpassword" type="password" class="layui-input" lay-verify="required" name="oldpassword" value=""  autocomplete="off" placeholder="请输入原始密码">
                </div>
            </div>
            <div class="layui-form-item " style="margin-left:20px;margin-top:10px;">
                <label class="layui-form-label">新设密码</label>
                <div class="layui-input-inline">
                    <input id="password" type="password" class="layui-input" lay-verify="required|password" name="password" value=""  autocomplete="off" placeholder="请输入新设密码">
                </div>
            </div>
            <div class="layui-form-item login-btn-box" style="margin-left:20px;">
                <button class="layui-btn" lay-submit="" lay-filter="infoset-box">提交</button>
            </div>
        </form>
    </fieldset>
</div>
@endsection
