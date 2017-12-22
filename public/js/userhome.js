layui.define(['layer', 'laytpl', 'form', 'table', 'common', 'form', 'layedit', 'upload'], function (exports) {

    var $ = layui.jquery,
            layer = layui.layer
            , table = layui.table
            , laytpl = layui.laytpl
            , common = layui.common
            , form = layui.form
            , layedit = layui.layedit
            , upload = layui.upload;

    query_dir = common.getQueryDir();
    console.log(query_dir);

    $(function () {
        if (query_dir !== '/userhome') {
            return false;
        }
        table.on('tool(articles)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
            var tr = obj.tr;
            if (layEvent === 'detail') {
                window.open("/home/article-detail/" + data.id + "");
            }
        });
        table.on('sort(articles)', function (obj) {
            table.reload('article_table', {
                initSort: obj
                , where: {
                    field: obj.field
                    , order: obj.type
                }
            });
        });

        $('#search').click(function () {
            table.reload('article_table', {
                url: '/userhome/articles'
                , where: {kw: $('#kw').val()}
            });
        });

    });

    $(function () {
        if (query_dir !== '/userhome/myarticles') {
            return false;
        }

        table.on('tool(articles)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
            var tr = obj.tr;
            if (layEvent === 'detail') {
                window.open("/home/article-detail/" + data.id + "");
            }
            if (layEvent === 'edit') {
                window.location.href = "/userhome/update-article/" + data.id + "";
            }
            if (layEvent === 'del') {
                layer.confirm('辛辛苦苦写的文章，就这么删除了？', {
                    btn: ['确定', '取消']
                }, function (index) {
                    $.post('/userhome/delete-article', {id: data.id}, function (res) {
                        if (res.code == 0) {
                            obj.del();
                            layer.close(index);
                            layer.msg('真的删了', {time: 2000, icon: 1});
                        } else {
                            layer.msg(res.msg, {time: 2000, icon: 5});
                        }
                    });
                    //
                });
            }
        });

        table.on('sort(articles)', function (obj) {
            table.reload('article_table', {
                initSort: obj
                , where: {
                    field: obj.field
                    , order: obj.type
                }
            });
        });

        $('#search').click(function () {
            table.reload('myarticle_table', {
                url: '/userhome/articles'
                , where: {kw: $('#kw').val()}
            });
        });
    });

    $(function () {
        if (query_dir !== '/userhome/new-article') {
            return false;
        }

        var index = common.layedit('content_text');

        form.on('submit(article-box)', function (data) {
            data.field['content'] = layedit.getContent(index);
            if (data.field['content'] === '' || $.trim(data.field['content']).length === 0) {
                layer.msg('请输入您的文章内容', {icon: 5});
                return false;
            }
            var data = data.field;
            common.json('/userhome/edit-article', {data}, function (res) {
                if (res.code === 0) {
                    layer.msg('操作成功', {icon: 1});
                    setTimeout(function () {
                        window.location.href = "/userhome/myarticles";
                    }, 2000);
                } else {
                    layer.msg(res.msg, {icon: 5});
                }
                return false;
            });
            return false;
        });
    });

    $(function () {
        if (query_dir.indexOf('/userhome/update-article') < 0) {
            return false;
        }

        var index = common.layedit('content_text');

        form.on('submit(article-box)', function (data) {
            data.field['content'] = layedit.getContent(index);
            if (data.field['content'] === '' || $.trim(data.field['content']).length === 0) {
                layer.msg('请输入您的文章内容', {icon: 5});
                return false;
            }
            var data = data.field;
            common.json('/userhome/edit-article', {data}, function (res) {
                if (res.code === 0) {
                    layer.msg('操作成功', {icon: 1});
                    setTimeout(function () {
                        window.location.href = "/userhome/myarticles";
                    }, 2000);
                } else {
                    layer.msg(res.msg, {icon: 5});
                }
                return false;
            });
            return false;
        });
    });

    $(function () {
        if (query_dir !== '/userhome/infoset') {
            return false;
        }
        $($(".layui-nav-item").children("a[href='/userhome/infoset']")).parent('li').addClass('layui-this');
        //换头像
        var uploadInst = upload.render({
            elem: '#user-avatar' //绑定元素
            , url: '/upload-avatar' //上传接口
            , done: function (res) {
                if (res.code == 0) {
                    $('#user-avatar').attr('src', res.src);
                    layer.msg('头像更换成功', {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 5});
                }
            }
            , error: function (res) {
                console.log('e:' + res);
            }
        });
        //修改密码
        form.verify({
            password: [/(.+){6,32}$/, '密码必须6到32位']
        });
        form.on('submit(infoset-box)', function (data) {
            $.post('/userhome/password_reset', {oldpassword: data.field.oldpassword, password: data.field.password}, function (res) {
                if (res.code == 0) {
                    layer.msg('密码已修改', {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 5});
                }
            });

            return false;
        });
        //修改签名
        $('.sign').change(function () {
            var sign = $('.sign').val();
            $.ajax({
                type: "POST",
                url: "/userhome/edit_sign",
                data: {sign: sign},
                dataType: "json",
                beforeSend: function () {
                    layer.load(0, {shade: 0.1});
                },
                success: function (res) {
                    layer.closeAll('loading');
                    if (res.code == 0) {
                        layer.msg(res.msg, {icon: 1});
                    } else {
                        layer.alert(res.msg, {icon: 5});
                    }
                }
            });
        });
    });




    $(function () {
        if (query_dir !== '/userhome/messages') {
            return false;
        }
    });

    $(function () {
        if (query_dir !== '/userhome/contact-back') {
            return false;
        }
        layui.use('table', function () {
            var table = layui.table;
            table.on('tool(articles)', function (obj) {
                var data = obj.data;
                var layEvent = obj.event;
                var tr = obj.tr;
                if (layEvent === 'detail') {
                    window.open("/home/article-detail/" + data.id + "");
                }
            });

        });

        form.verify({
            content: function (val) {
                if (val == '' || $.trim(val).length === 0) {
                    return '内容不能为空';
                }
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

    exports('userhome');
});





