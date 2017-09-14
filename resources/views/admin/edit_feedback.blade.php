
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
                    <input type="hidden" name='id' value='{{ $feedback->id}}'>
                    <div class="layui-form-item ">
                        <label class="layui-form-label">类型</label>
                        <div class="layui-input-inline">
                            <select name="mid">
                                <option value="1" @if(isset($feedback->mid) && $feedback->mid == 1) selected @endif>作者认证</option>
                                <option value="2" @if(isset($feedback->mid) && $feedback->mid == 2) selected @endif>BUG反馈</option>
                                <option value="3" @if(isset($feedback->mid) && $feedback->mid == 3) selected @endif>友链申请</option>
                                <option value="4" @if(isset($feedback->mid) && $feedback->mid == 4) selected @endif>其他</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否通过</label>
                        <div class="layui-input-inline">
                            <select name="status">
                                <option value="0" @if(isset($feedback->status) && $feedback->status == 0) selected @endif>待处理</option>
                                <option value="1" @if(isset($feedback->status) && $feedback->status == 1) selected @endif>拒绝</option>
                                <option value="2" @if(isset($feedback->status) && $feedback->status == 2) selected @endif>已处理</option>
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
                        <button class="layui-btn" lay-submit="" lay-filter="category-box">提交</button>
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
    form.on('submit(category-box)', function (data) {
        var data = data.field;
        $.post('/admin/save-feedback', {data}, function (res) {
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