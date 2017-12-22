@extends('layouts.userhome')

@section('content')
<div style="padding: 15px;overflow: hidden">
    <fieldset class="layui-col-md4 layui-col-xs12 layui-elem-field">
        <legend>个人信息</legend>
        <div class="layui-field-box user-box">
            <div class="layui-col-xs3">
                <div class="site-demo-upload">
                    <img id="user-avatar" title="点击上传,建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB" src="{{ isset(Auth::user()->avatar) ? Auth::user()->avatar : '/images/avatar/'.rand(1,11).'.jpg' }} " class="layui-user-img">
                    <input type="file" name="file" class="layui-upload-file" id="img">
                </div>

            </div>
            <div class="layui-col-md4 layui-col-xs4 layui-col-xs-offset1 layui-col-md-offset1 margin-top30">
                {{ Auth::user()->name }} 
                @if(Auth::user()->gender == '男')
                <i class="layui-icon man">&#xe662;</i>
                @else
                <i class="layui-icon woman">&#xe661;</i>
                @endif

                @if(Auth::user()->is_author==2)
                <span class="layui-badge-rim layui-bg-orange">管理员 </span>
                @elseif(Auth::user()->is_author==1)
                <span class="layui-badge-rim layui-bg-blue">发布者</span>
                @endif
            </div>
            <div class="layui-col-xs6 layui-col-md-offset1  layui-col-md6 layui-col-xs-offset1 margin-top10">
                <input class="sign layui-elip" placeholder="编辑签名" value="{{ Auth::user()->sign }}">
            </div>
        </div>
    </fieldset>

</div>



<div style="padding: 15px;overflow: hidden">

    <fieldset class="layui-col-md4 layui-col-xs12 layui-elem-field">
        <legend>安全设置</legend>
        <form class="layui-form layui-form-pane " method="POST" >
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
