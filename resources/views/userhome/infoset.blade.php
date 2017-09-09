@extends('userhome.userhome')

@section('userhomecontent')

<div class="layui-body">
    <div style="padding: 15px;">
        <fieldset class="layui-col-md4 layui-col-xs12 layui-elem-field">
            <legend>个人信息</legend>
            <div class="layui-field-box user-box">
                <div class="layui-col-xs3">
                    <div class="site-demo-upload">
                        <img id="user-avatar" src="/images/avatar/{{ isset(Auth::user()->avatar) ?Auth::user()->avatar :rand(1,11).'.jpg' }} " class="layui-user-img">
                        <input type="file" name="file" class="layui-upload-file" id="img">
                    </div>

                </div>
                <div class="layui-col-md4 layui-col-xs4 layui-col-xs-offset1 layui-col-md-offset1 margin-top30">
                    {{ Auth::user()->name }} 
                    @if(Auth::user()->gender == '男')
                    <i class="layui-icon man">&#xe662;</i>
                    @else
                    <i class="layui-icon woman">&#xe661;</i>
                    @endif

                    @if(Auth::user()->is_author==2)
                    <span class="layui-badge-rim layui-bg-orange">管理员 </span>
                    @elseif(Auth::user()->is_author==1)
                    <span class="layui-badge-rim layui-bg-blue">发布者</span>
                    @endif
                </div>
                <div class="layui-col-xs6 layui-col-md-offset1  layui-col-md6 layui-col-xs-offset1 margin-top10">
                    <input class="sign layui-elip" placeholder="编辑签名" value="{{ Auth::user()->sign }}">
                </div>
            </div>
        </fieldset>

    </div>
</div>
<script>
    layui.use('upload', function () {
        var upload = layui.upload;
        var uploadInst = upload.render({
            elem: '#user-avatar' //绑定元素
            , url: '/upload/' //上传接口
            , done: function (res) {
                //上传完毕回调
            }
            , error: function () {
                //请求异常回调
            }
        });
    });
</script>
@endsection
