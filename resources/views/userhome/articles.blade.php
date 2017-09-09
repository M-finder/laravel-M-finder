@extends('userhome.userhome')

@section('userhomecontent')

<div class="layui-body">
    <div class="layui-col-md6 layui-col-xs12" style="padding: 15px;">
        <table class="layui-table" lay-filter="articles" lay-data="{url:'/userhome/articles',method: 'post',page: true,limit: 20,groups: 3,response: { statusName: 'code', statusCode: 0 , msgName: 'msg' , countName: 'count', dataName: 'data'},}">
            <thead>
                <tr>
                    <th lay-data="{field:'id', width:98, sort: true}">ID</th>
                    <th lay-data="{field:'title', width:300}">标题</th>
                    <th lay-data="{field:'author', width:120}">作者</th>
                    <th lay-data="{field:'read', width:100}">已读</th>
                    <th lay-data="{field:'like', width:100}">获赞</th>
                    <th lay-data="{field:'right', width:100, toolbar: '#bar'}">操作</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script type="text/html" id="bar">
    <a class="layui-btn layui-btn-mini" lay-event="detail">查看</a>
</script>

@endsection
