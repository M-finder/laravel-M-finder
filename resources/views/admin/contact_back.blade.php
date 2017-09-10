@extends('layouts.admin')

@section('admincontent')

<div class="layui-body">
    <!-- 内容主体区域 -->
    <div class="layui-col-md8 layui-col-xs12" style="padding: 15px;">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li lay-id='list' class="layui-this">联系记录</li>
                <li></li>
            </ul>

            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <table class="layui-table" lay-filter="messages" lay-data="{url:'/admin/feedbacks',method: 'post',page: true,limit: 20,groups: 3,response: { statusName: 'code', statusCode: 0 , msgName: 'msg' , countName: 'count', dataName: 'data'},}">
                        <thead>
                            <tr>
                                <th lay-data="{field:'id', width:90, sort: true}">ID</th>
                                <th lay-data="{field:'mid', width:120}">类型</th>
                                <th lay-data="{field:'content', width:241}">内容</th>
                                <th lay-data="{field:'status', width:120}">状态</th>
                                <th lay-data="{field:'reason', width:120}">状态说明</th>
                                <th lay-data="{field:'right', width:200, toolbar: '#bar'}">操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/html" id="bar">
            <a class="layui-btn layui-btn-mini" lay-event="edit">处理</a>
            </script>
            <script>
                layui.use(['form', 'layedit', 'laydate', 'element'], function () {
                    var form = layui.form, layer = layui.layer, layedit = layui.layedit, element = layui.element;
                });
            </script>
        </div>
    </div>
    @endsection