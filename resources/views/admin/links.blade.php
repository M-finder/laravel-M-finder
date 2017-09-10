@extends('layouts.admin')

@section('admincontent')

<div class="layui-body">
    <!-- 内容主体区域 -->
    <div class="layui-col-md8 layui-col-xs12" style="padding: 15px;">
        <form class="layui-form layui-form-pane" method="POST" >
            <div class="layui-form-item " style="margin-top:10px;">
                <div class="layui-word-aux">
                    <button class="layui-btn" type="button" id='add-links'>添加</button>
                </div>
            </div>
        </form>
        
        <table class="layui-table" lay-filter="links" lay-data="{id:'links_table',url:'/admin/get-links',method: 'post',page: true,limit: 20,groups: 3,response: { statusName: 'code', statusCode: 0 , msgName: 'msg' , countName: 'count', dataName: 'data'},}">
            <thead>
                <tr>
                    <th lay-data="{field:'id', width:99, sort: true}">ID</th>
                    <th lay-data="{field:'name', width:120}">名称</th>
                    <th lay-data="{field:'link', width:300}">地址</th>
                    <th lay-data="{field:'right', width:200, toolbar: '#bar'}">操作</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script type="text/html" id="bar">
    <a class="layui-btn layui-btn-mini" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del">删除</a>
</script>
@endsection
