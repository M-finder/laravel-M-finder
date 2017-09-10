@extends('layouts.admin')

@section('admincontent')

<div class="layui-body">
    <!-- 内容主体区域 -->
    <div class="layui-col-md6 layui-col-xs12" style="padding: 15px;">
        <form class="layui-form layui-form-pane " method="POST" >
            <div class="layui-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">文章内容</li>
                    <li>SEO设置</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <input type="hidden" name='id' value='{{ $menu->id or '' }}'>
                        <input type="hidden" name='token' value='{{ $token or '' }}'>
                        <div class="layui-form-item ">
                            <label class="layui-form-label">分类名称</label>
                            <div class="layui-input-block">
                                <input id="name" type="text" class="layui-input" lay-verify="required" name="name" value="{{ $menu->name or  '' }}"  autocomplete="off" placeholder="请输入分类名称">
                            </div>
                        </div>


                        <div class="layui-form-item">
                            <label class="layui-form-label">是否显示</label>
                            <div class="layui-input-inline">
                                <select name="is_show">
                                    <option value="2" @if(isset($menu->is_show) && $menu->is_show == 2) selected @endif>显示</option>
                                    <option value="1" @if(isset($menu->is_show) && $menu->is_show == 1) selected @endif>隐藏</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item" pane="">
                            <label class="layui-form-label">栏目类型</label>
                            <div class="layui-input-block">
                                <input type="radio" lay-filter="type"  name="type" value="0" title="分类"  @if(isset($menu->type) && $menu->type == 0) checked="" @endif >
                                <input type="radio" lay-filter="type"  name="type" value="1" title="单页" @if(isset($menu->type) && $menu->type == 1) checked="" @endif >
                                <input type="radio" lay-filter="type"  name="type" value="2" title="链接" @if(isset($menu->type) && $menu->type == 2) checked="" @endif >
                            </div>
                        </div>

                        <div class="layui-form-item" id="link"  @if(isset($menu->type) && $menu->type != 2) style="display:none;" @endif >
                            <label class="layui-form-label">链接地址</label>
                            <div class="layui-input-block">
                                <input type="text" name="link" placeholder="请输入链接地址" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item layui-form-text" id="setcontent" @if(isset($menu->type) && $menu->type != 1) style="display:none;" @endif >
                            <label class="layui-form-label">单页内容</label>
                            <div class="layui-input-block ">
                                <textarea id="content" name="content" lay-verify="content">{{ $menu->content or '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="layui-form-item">
                            <label class="layui-form-label">SEO标题</label>
                            <div class="layui-input-inline">
                                <input type="text" name="seo_title" placeholder="请输入SEO标题" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">SEO描述</label>
                            <div class="layui-input-block">
                                <textarea placeholder="请输入内容" name="seo_describe" class="layui-textarea"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="layui-form-item login-btn-box">
                <button class="layui-btn" lay-submit="" lay-filter="category-box">提交</button>
            </div>
        </form>

        <script>
            $($(".layui-nav-item").children("a[href='/admin/category']")).parent('li').addClass('layui-this');

            layui.use(['form', 'layedit', 'laydate'], function () {
                var form = layui.form, layer = layui.layer, layedit = layui.layedit;
                layedit.set({
                    uploadImage: {
                        url: '/upload-img' //接口url  {"code": 0 ,"msg": "" ,"data": {"src": "图片路径","title": "图片名称"}
                        , type: 'post' //默认post
                    }
                });

                form.on('radio(type)', function (data) {
                    if (data.value == 0) {
                        $('#link').hide();
                        $('#setcontent').hide();
                    }
                    if (data.value == 1) {
                        $('#setcontent').show();
                        $('#link').hide();
                    }
                    if (data.value == 2) {
                        $('#setcontent').hide();
                        $('#link').show();
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
                        layedit.sync(index);
                    }
                });
                //事件监听
                form.on('submit(category-box)', function (data) {
                    var data = data.field;
                    $.post('/admin/edit-category', {data}, function (res) {
                        if (res.code == 0) {
                            layer.msg('操作成功', {icon: 1});
                            setTimeout(function () {
                                window.location.href = "/admin/category";
                            }, 2000);
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