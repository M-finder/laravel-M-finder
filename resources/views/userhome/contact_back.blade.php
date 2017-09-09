@extends('userhome.userhome')

@section('userhomecontent')

<div class="layui-body">
    <!-- 内容主体区域 -->
    <div class="layui-col-md8 layui-col-xs12" style="padding: 15px;">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li class="layui-this">联系后台</li>
                <li lay-id='list'>联系记录</li>
            </ul>

            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <form class="layui-form layui-form-pane login-box" method="POST" >
                        <input type="hidden" name='token' value='{{ $token or '' }}'>
                        <div class="layui-form-item">
                            <label class="layui-form-label">分类</label>
                            <div class="layui-input-inline">
                                <select name="mid">
                                    <option value="1">作者认证</option>
                                    <option value="2">BUG反馈</option>
                                    <option value="3">友链申请</option>
                                    <option value="4">其他</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">内容</label>
                            <div class="layui-input-block ">
                                <textarea id="content" name="content" lay-verify="content"></textarea>
                            </div>
                        </div>

                        <div class="layui-form-item login-btn-box">
                            <button class="layui-btn" lay-submit="" lay-filter="feedback-box">发表</button>
                        </div>
                    </form>
                </div>
                <div class="layui-tab-item" >
                    <div class="layui-col-md8 layui-col-xs12" style="padding: 15px;">
                        <table class="layui-table" lay-filter="articles" lay-data="{url:'/userhome/feedbacks',method: 'post',page: true,limit: 20,groups: 3,response: { statusName: 'code', statusCode: 0 , msgName: 'msg' , countName: 'count', dataName: 'data'},}">
                            <thead>
                                <tr>
                                    <th lay-data="{field:'id', width:90, sort: true}">ID</th>
                                    <th lay-data="{field:'mid', width:120}">类型</th>
                                    <th lay-data="{field:'content', width:241}">内容</th>
                                    <th lay-data="{field:'status', width:120}">状态</th>
                                    <th lay-data="{field:'reason', width:120}">状态说明</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $($(".layui-nav-item").children("a[href='/userhome/contact-back']")).parent('li').addClass('layui-this');

            layui.use(['form', 'layedit', 'laydate', 'element'], function () {
                var form = layui.form, layer = layui.layer, layedit = layui.layedit, element = layui.element;
                layedit.set({
                    uploadImage: {
                        url: '/upload-img'
                        , type: 'post'
                    }
                });
                var index = layedit.build('content', {
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
                        if (val == '' || $.trim(val).length === 0) {
                            return '内容不能为空';
                        }
                        layedit.sync(index);
                    }
                });
                //事件监听
                form.on('submit(feedback-box)', function (data) {
                    var data = data.field;
                    $.post('/userhome/feedback', {data}, function (res) {
                        if (res.code == 0) {
                            layer.msg('操作成功', {icon: 1});
                        } else {
                            layer.msg(res.msg, {icon: 5});
                        }
                        return false;
                    });
                    return false;
                });
            });
        </script>
    </div>
</div>
@endsection