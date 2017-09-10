
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('js/layui/layui.js') }}"></script>
        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/common.js') }}"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
        <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
        <link href="{{ asset('css/global.css') }}" rel="stylesheet">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
        <link rel="icon" href="{{ asset('/favicon.ico')}}"> 
    </head>
    <body>
        <div class="layui-body">
            <!-- 内容主体区域 -->
            <div class="layui-col-md6 layui-col-xs12" style="padding: 15px;">
                <form class="layui-form layui-form-pane " method="POST" >
                    <input type="hidden" name='id' value='{{ $user->id}}'>
                    <div class="layui-form-item ">
                        <label class="layui-form-label">用户名称</label>
                        <div class="layui-input-block">
                            <input id="name" type="text" class="layui-input" lay-verify="required" name="name" value="{{ $user->name or  '' }}"  autocomplete="off" placeholder="请输入用户名称">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">是否认证</label>
                        <div class="layui-input-inline">
                            <select name="is_author">
                                <option value="0" @if(isset($user->is_author) && $user->is_author == 0) selected @endif>普通用户</option>
                                <option value="1" @if(isset($user->is_author) && $user->is_author == 1) selected @endif>认证作者</option>
                                <option value="2" @if(isset($user->is_author) && $user->is_author == 2) selected @endif>管理员</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item login-btn-box">
                        <button class="layui-btn" lay-submit="" lay-filter="user-box">提交</button>
                    </div>
                </form>
            </div>

        </div>
        <script>
layui.use(['form', 'layedit', 'laydate'], function () {
    var form = layui.form, layer = layui.layer, layedit = layui.layedit;
    var index = layedit.build('reason', {
        height: 120,
        tool: [
            'strong' //加粗
                    , 'italic' //斜体
                    , 'underline' //下划线
                    , 'del' //删除线
                    , '|' //分割线
                    , 'left' //左对齐
                    , 'center' //居中对齐
                    , 'right' //右对齐
                    , 'link' //超链接
                    , 'unlink' //清除链接
                    , 'face' //表情
                    , 'image' //插入图片
                    , 'code' //帮助
        ]
    });
    //自定义验证规则
    form.verify({
        content: function (val) {
            layedit.sync(index);
        }
    });
    //事件监听
    form.on('submit(user-box)', function (data) {
        var data = data.field;
        $.post('/admin/save-user', {data}, function (res) {
            if (res.code == 0) {
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