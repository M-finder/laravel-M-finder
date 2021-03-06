@extends('layouts.userhome')

@section('content')

<div class="layui-col-md8 layui-col-xs12" style="padding: 15px;">
    <div class="layui-tab">
        <ul class="layui-tab-title">
            <li class="layui-this">联系后台</li>
            <li lay-id='list'>联系记录</li>
        </ul>

        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form layui-form-pane login-box" method="POST" >
                    <input type="hidden" name='token' value='{{ $token or '' }}'>
                    <div class="layui-form-item">
                        <label class="layui-form-label">分类</label>
                        <div class="layui-input-inline">
                            <select name="mid">
                                <option value="1">作者认证</option>
                                <option value="2">BUG反馈</option>
                                <option value="3">友链申请</option>
                                <option value="4">其他</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <div class="layui-form-item layui-form-text">
                            <div class="layui-input-block ">
                                <textarea id="comment_text" name="content"  cols="45" rows="8" maxlength="65525" lay-verify="content" aria-required="true" class="layui-textarea fly-editor">{{ $article->content or '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item login-btn-box">
                        <button class="layui-btn" lay-submit="" lay-filter="feedback-box">发表</button>
                    </div>
                </form>
            </div>
            <div class="layui-tab-item" >
                <div class="layui-col-md8 layui-col-xs12" style="padding: 15px;">
                    <table class="layui-table" lay-filter="articles" lay-data="{url:'/userhome/feedbacks',method: 'post',page: true,limit: 20,groups: 3,response: { statusName: 'code', statusCode: 0 , msgName: 'msg' , countName: 'count', dataName: 'data'},}">
                        <thead>
                            <tr>
                                <th lay-data="{field:'id', width:90, sort: true}">ID</th>
                                <th lay-data="{field:'mid', width:120}">类型</th>
                                <th lay-data="{field:'content', width:241}">内容</th>
                                <th lay-data="{field:'status', width:120}">状态</th>
                                <th lay-data="{field:'reason', width:120}">状态说明</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection