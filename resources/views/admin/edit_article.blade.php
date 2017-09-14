@extends('layouts.admin')

@section('admincontent')

<div class="layui-body">
    <!-- 内容主体区域 -->
    <div class="layui-col-md6 layui-col-xs12" style="padding: 15px;">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li class="layui-this">文章内容</li>
                <li></li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">

                    <form class="layui-form layui-form-pane login-box" method="POST" >
                        <input type="hidden" name='id' value='{{ $article->id or '' }}'>
                        <input type="hidden" name='token' value='{{ $token or '' }}'>
                        <div class="layui-form-item ">
                            <label class="layui-form-label">文章标题</label>
                            <div class="layui-input-block">
                                <input id="title" type="text" class="layui-input" lay-verify="required|title" name="title" value="{{ $article->title or  '' }}"  autocomplete="off" placeholder="请输入文章标题">
                            </div>
                        </div>


                        <div class="layui-form-item">
                            <label class="layui-form-label">所属分类</label>
                            <div class="layui-input-inline">
                                <select name="mid">
                                    @foreach($menus as $menu)
                                    <option value="{{ $menu['id'] }}" @if(isset($article->mid) && $article->mid == $menu['id']) selected @endif>{{ $menu['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <div class="layui-input-block ">
                                <textarea id="comment_text" name="content"  cols="45" rows="8" maxlength="65525" lay-verify="content" aria-required="true" class="layui-textarea fly-editor">{{ $article->content or '' }}</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item login-btn-box">
                            <button class="layui-btn" lay-submit="" lay-filter="article-box">发表</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $($(".layui-nav-item").children("a[href='/admin/dashboard']")).parent('li').addClass('layui-this');
            layui.use(['form', 'layedit', 'laydate'], function () {
                var form = layui.form, layer = layui.layer, layedit = layui.layedit;
                //自定义验证规则
                form.verify({
                    title: function (val) {
                        if (val == '' || $.trim(val).length === 0) {
                            return '标题不能为空';
                        }
                    }
                    , content: function (val) {
                        if (val == '' || $.trim(val).length === 0) {
                            return '内容不能为空';
                        }
                    }
                });
                //事件监听
                form.on('submit(article-box)', function (data) {
                    var data = data.field;
                    $.post('/admin/edit-article', {data}, function (res) {
                        if (res.code == 0) {
                            layer.msg('操作成功', {icon: 1});
                            setTimeout(function () {
                                window.location.href = "/admin/dashboard";
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