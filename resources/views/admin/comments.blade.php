@extends('layouts.admin')

@section('content')

    <div class="layui-col-md8 layui-col-xs12" style="padding: 15px;">
        <table class="layui-table" lay-filter="comments" lay-data="{id:'comments_table',url:'/admin/get-comments',method: 'post',page: true,limit: 20,groups: 3,response: { statusName: 'code', statusCode: 0 , msgName: 'msg' , countName: 'count', dataName: 'data'},}">
            <thead>
                <tr>
                    <th lay-data="{field:'id',sort: true}">ID</th>
                    <th lay-data="{field:'name'}">用户名称</th>
                    <th lay-data="{field:'title'}">文章标题</th>
                    <th lay-data="{field:'content' }">评论内容</th>
                    <th lay-data="{field:'right', width:100, toolbar: '#bar'}">操作</th>
                </tr>
            </thead>
        </table>
    </div>
<script type="text/html" id="bar">
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
</script>
@endsection
