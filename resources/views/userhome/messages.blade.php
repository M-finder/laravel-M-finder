@extends('layouts.userhome')

@section('userhomecontent')

<div class="layui-body">
    <!-- 内容主体区域 -->
    <div class="layui-col-md6 layui-col-xs8" style="padding: 15px;">
        <table class="layui-table" lay-filter="messages" lay-data="{url:'/userhome/mymessages',method: 'post', where: {uid: $('#uid').data('uid')},page: true,limit: 20,groups: 3,response: { statusName: 'code', statusCode: 0 , msgName: 'msg' , countName: 'count', dataName: 'data'},}">
            <thead>
                <tr>
                    <th lay-data="{field:'id', width:90, sort: true}">ID</th>
                    <th lay-data="{field:'title', width:281}">说明</th>
                    <th lay-data="{field:'content', width:450}">内容</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script type="text/html" id="bar">
    <a class="layui-btn layui-btn-primary layui-btn-mini" lay-event="detail">查看</a>
</script>
@endsection
