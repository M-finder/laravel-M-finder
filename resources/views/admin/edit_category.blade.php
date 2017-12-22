@extends('layouts.admin')

@section('content')

<div class="layui-col-md6 layui-col-xs12" style="padding: 15px;">
    <form class="layui-form layui-form-pane " method="POST" action='/admin/edit-category' onsubmit="return false;">
        <div class="layui-tab">
            <ul class="layui-tab-title">
                <li class="layui-this">文章内容</li>
                <li></li>
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
                            <textarea id="content_text" name="content"  cols="45" rows="8" maxlength="65525" lay-verify="content" aria-required="true" class="layui-textarea fly-editor">{{ $menu->content or '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item login-btn-box">
            <button class="layui-btn" lay-submit="" lay-filter="category-box">提交</button>
        </div>
    </form>
</div>
@endsection