@extends('layouts.userhome')

@section('content')

<div class="layui-col-md8 layui-col-xs12" style="padding: 15px;">
    <table class="layui-table" lay-filter="messages" lay-data="{url:'/userhome/mymessages',method: 'post', where: {uid: $('#uid').data('uid')},page: true,limit: 20,groups: 3,response: { statusName: 'code', statusCode: 0 , msgName: 'msg' , countName: 'count', dataName: 'data'},}">
        <thead>
            <tr>
                <th lay-data="{field:'id', sort: true}">ID</th>
                <th lay-data="{field:'title'}">说明</th>
                <th lay-data="{field:'content', width:450}">内容</th>
            </tr>
        </thead>
    </table>
</div>
@endsection
