@extends('layouts.userhome')

@section('content')

<!-- 内容主体区域 -->
<div class="layui-col-md8 layui-col-xs12" style="padding: 15px;">
    <form class="layui-form layui-form-pane" method="POST" >
        <div class="layui-form-item " style="margin-top:10px;">
            <label class="layui-form-label">文章标题</label>
            <div class="layui-input-inline">
                <input id="kw" type="text" class="layui-input"  value="" autocomplete="off" placeholder="请输入文章标题">
            </div>
            <div class="layui-word-aux">
                <button class="layui-btn" type="button" id='search'>查询</button>
            </div>
        </div>
    </form>

    <table class="layui-table" lay-filter="articles" lay-data="{id:'myarticle_table',url:'/userhome/articles',method: 'post', where: {uid: $('#uid').data('uid')},page: true,limit: 20,groups: 3,response: { statusName: 'code', statusCode: 0 , msgName: 'msg' , countName: 'count', dataName: 'data'},}">
        <thead>
            <tr>
                <th lay-data="{field:'id',sort: true}">ID</th>
                <th lay-data="{field:'title'}">标题</th>
                <th lay-data="{field:'author'}">作者</th>
                <th lay-data="{field:'read'}">已读</th>
                <th lay-data="{field:'like'}">获赞</th>
                <th lay-data="{field:'status'}">状态</th>
                <th lay-data="{field:'reason'}">状态说明</th>
                <th lay-data="{field:'right', width:200, toolbar: '#bar'}">操作</th>
            </tr>
        </thead>
    </table>
</div>
<script type="text/html" id="bar">
    <a class="layui-btn layui-btn-primary layui-btn-sm" lay-event="detail">查看</a>
    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
@endsection
