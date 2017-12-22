<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('js/layui/layui.js') }}"></script>
        <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
        <link rel="icon" href="{{ asset('/favicon.ico')}}"> 
    </head>
    <body>
        <div class="layui-body">
            <!-- 内容主体区域 -->
            <div class="layui-col-md6 layui-col-xs12" style="padding: 15px;">
                <form class="layui-form layui-form-pane " method="POST" onsubmit="return false;">
                    <input type="hidden" name='id' value='{{ $link->id or ''}}'>
                    <div class="layui-form-item ">
                        <label class="layui-form-label">链接名称</label>
                        <div class="layui-input-block">
                            <input id="name" type="text" class="layui-input" lay-verify="required" name="name" value="{{ $link->name or  '' }}"  autocomplete="off" placeholder="请输入链接名称">
                        </div>
                    </div>

                    <div class="layui-form-item ">
                        <label class="layui-form-label">链接地址</label>
                        <div class="layui-input-block">
                            <input id="link" type="text" class="layui-input" lay-verify="required" name="link" value="{{ $link->link or  '' }}"  autocomplete="off" placeholder="请输入链接地址,以 http::// 开头">
                        </div>
                    </div>
                    <div class="layui-form-item login-btn-box">
                        <button class="layui-btn" lay-submit="" lay-filter="article-box">提交</button>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            layui.config({
                base: '/js/'
                , version: false
            }).extend({
                admin: 'admin',
                pjax: 'pjax'
            }).use(['admin', 'pjax'], function () {
                var $ = layui.jquery,form = layui.form,common = layui.common,table = layui.table;
                form.on('submit(article-box)', function (data) {
                    var data = data.field;
                    common.json('/admin/save-link', {data}, function (res) {
                        if (res.code === 0) {
                            layer.msg('操作成功', {icon: 1});
                            setTimeout(function () {
                                parent.location.reload();
                                layer.closeAll();
                            }, 1500);

                        } else {
                            layer.msg(res.msg, {icon: 5});
                        }
                        return false;
                    });
                    return false;
                });
            });
        </script>
    </body>
</html>