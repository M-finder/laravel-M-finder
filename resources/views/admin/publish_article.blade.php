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
                <form class="layui-form layui-form-pane " method="POST" >
                    <input type="hidden" name='id' value='{{ $article->id}}'>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否通过</label>
                        <div class="layui-input-inline">
                            <select name="status">
                                <option value="0" @if(isset($article->status) && $article->status == 0) selected @endif>待处理</option>
                                <option value="1" @if(isset($article->status) && $article->status == 1) selected @endif>拒绝</option>
                                <option value="2" @if(isset($article->status) && $article->status == 2) selected @endif>已处理</option>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">状态说明</label>
                        <div class="layui-input-block ">
                            <textarea id="comment_text" name="content"  cols="45" rows="8" maxlength="65525" lay-verify="content" aria-required="true" class="layui-textarea fly-editor">已处理,感谢您的贡献</textarea>
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
                    common.json('/admin/save-article', {data}, function (res) {
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