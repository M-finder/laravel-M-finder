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
        if (query_dir !== '/admin/dashboard') {
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
                window.location.href = "/admin/update-article/" + data.id + "";
            }
            if (layEvent === 'publish') {
                layer.open({
                    type: 2,
                    title: '后台文章处理',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['700px', '600px'],
                    content: '/admin/publish-article/' + data.id
                });
            }
            if (layEvent === 'del') {
                layer.confirm('辛辛苦苦写的文章，就这么删除了？', {
                    btn: ['确定', '取消'] //按钮
                }, function (index) {
                    $.post('/admin/delete-article', {id: data.id}, function (res) {
                        if (res.code == 0) {
                            obj.del();
                            layer.close(index);
                            layer.msg('真的删了', {time: 2000, icon: 1});
                        } else {
                            layer.msg(res.msg, {time: 2000, icon: 5});
                        }
                    });
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
            table.reload('article_table', {
                url: '/admin/articles'
                , where: {kw: $('#kw').val()}
            });
        });
    });



    $(function () {
        if (query_dir.indexOf('/admin/update-article') < 0) {
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
            common.json('/admin/edit-article', {data}, function (res) {
                if (res.code === 0) {
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

    $(function () {
        if (query_dir !== '/admin/infoset') {
            return false;
        }

        form.verify({
            password: [/(.+){6,32}$/, '密码必须6到32位']
        });
        form.on('submit(infoset-box)', function (data) {
            common.json('/admin/password_reset', {oldpassword: data.field.oldpassword, password: data.field.password}, function (res) {
                if (res.code === 0) {
                    layer.msg(res.msg, {icon: 1});
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
                url: "/admin/edit_sign",
                data: {sign: sign},
                dataType: "json",
                beforeSend: function () {
                    layer.load(0, {shade: 0.1});
                },
                success: function (res) {
                    layer.closeAll('loading');
                    if (res.code === 0) {
                        layer.msg(res.msg, {icon: 1});
                    } else {
                        layer.alert(res.msg, {icon: 5});
                    }
                }
            });
        });
    });

    $(function () {
        if (query_dir !== '/admin/category') {
            return false;
        }
        table.on('tool(menus)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
            var tr = obj.tr;
            if (layEvent === 'edit') {
                window.location.href = "/admin/update-category/" + data.id + "";
            }
            if (layEvent === 'del') {
                layer.confirm('删除分类前请确保分类下已无文章？', {
                    btn: ['确定', '取消']
                }, function (index) {
                    common.json('/admin/delete-category', {id: data.id}, function (res) {
                        if (res.code === 0) {
                            obj.del();
                            layer.close(index);
                            layer.msg('真的删了', {time: 2000, icon: 1});
                        } else {
                            layer.msg(res.msg, {time: 2000, icon: 5});
                        }
                    });
                });
            }
        });

        $('#search').click(function () {
            table.reload('menus_table', {
                url: '/admin/categorys'
                , where: {kw: $('#kw').val()}
            });
        });

        $('#add-cate').click(function () {
            window.location.href = "/admin/new-category";
        });



    });

    $(function () {
        if (query_dir.indexOf('/admin/update-category') < 0) {
            return false;
        }

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

        var index = common.layedit('content_text');

        form.on('submit(category-box)', function (data) {
            data.field['content'] = layedit.getContent(index);
            var data = data.field;
            common.json('/admin/edit-category', {data}, function (res) {
                if (res.code === 0) {
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
    $(function () {
        if (query_dir !== '/admin/new-category') {
            return false;
        }

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

        var index = common.layedit('content_text');

        form.on('submit(category-box)', function (data) {
            data.field['content'] = layedit.getContent(index);
            var data = data.field;
            common.json('/admin/edit-category', {data}, function (res) {
                if (res.code === 0) {
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



    $(function () {
        if (query_dir !== '/admin/messages') {
            return false;
        }
        table.on('tool(messages)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
            var tr = obj.tr;
            if (layEvent === 'edit') {
                layer.open({
                    type: 2,
                    title: '后台消息处理',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['700px', '600px'],
                    content: '/admin/edit-feedback/' + data.id
                });
            }
            if (layEvent === 'del') {
                layer.confirm('删除分类前请确保分类下已无文章？', {
                    btn: ['确定', '取消'] //按钮
                }, function (index) {
                    $.post('/admin/delete-category', {id: data.id}, function (res) {
                        if (res.code == 0) {
                            obj.del();
                            layer.close(index);
                            layer.msg('真的删了', {time: 2000, icon: 1});
                        } else {
                            layer.msg(res.msg, {time: 2000, icon: 5});
                        }
                    });
                });
            }

        });
        $('#search').click(function () {
            table.reload('menus_table', {
                url: '/admin/categorys'
                , where: {kw: $('#kw').val()}
            });
        });
        $('#add-cate').click(function () {
            window.location.href = "/admin/new-category";
        });
    });


    $(function () {
        if (query_dir !== '/admin/user') {
            return false;
        }

        table.on('tool(users)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
            var tr = obj.tr;
            if (layEvent === 'edit') {
                layer.open({
                    type: 2,
                    title: '用户管理',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['700px', '400px'],
                    content: '/admin/edit-user/' + data.id
                });
            }
            if (layEvent === 'del') {
                layer.confirm('确认删除该用户？', {
                    btn: ['确定', '取消'] //按钮
                }, function (index) {
                    $.post('/admin/delete-user', {id: data.id}, function (res) {
                        if (res.code == 0) {
                            obj.del();
                            layer.close(index);
                            layer.msg('真的删了', {time: 2000, icon: 1});
                        } else {
                            layer.msg(res.msg, {time: 2000, icon: 5});
                        }
                    });
                });
            }

        });
        $('#search').click(function () {
            table.reload('users_table', {
                url: '/admin/users'
                , where: {kw: $('#kw').val()}
            });
        });
        $('#add-cate').click(function () {
            window.location.href = "/admin/new-category";
        });

    });


    $(function () {
        if (query_dir !== '/admin/links') {
            return false;
        }
        table.on('tool(links)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
            var tr = obj.tr;
            if (layEvent === 'edit') {
                layer.open({
                    type: 2,
                    title: '友链管理',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['700px', '400px'],
                    content: '/admin/edit-links/' + data.id
                });
            }
            if (layEvent === 'del') {
                layer.confirm('确认删除该链接？', {
                    btn: ['确定', '取消'] //按钮
                }, function (index) {
                    $.post('/admin/delete-link', {id: data.id}, function (res) {
                        if (res.code == 0) {
                            obj.del();
                            layer.close(index);
                            layer.msg('真的删了', {time: 2000, icon: 1});
                        } else {
                            layer.msg(res.msg, {time: 2000, icon: 5});
                        }
                    });
                });
            }

        });

        $('#add-links').click(function () {
            layer.open({
                type: 2,
                title: '友链管理',
                shadeClose: true,
                shade: false,
                maxmin: true, //开启最大化最小化按钮
                area: ['700px', '400px'],
                content: '/admin/edit-links/'
            });
        });
    });


    $(function () {
        if (query_dir !== '/admin/syscoonfig') {
            return false;
        }
        form.on('submit(sysconfig-box)', function (data) {
            var data = data.field;
            common.json('/admin/edit-sysconfig', {data}, function (res) {
                if (res.code === 0) {
                    layer.msg('操作成功', {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 5});
                }
                return false;
            });
            return false;
        });
    });

    $(function () {
        if (query_dir !== '/admin/comments') {
            return false;
        }
        table.on('tool(comments)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
            var tr = obj.tr;

            if (layEvent === 'del') {
                layer.confirm('确认删除该评论？', {
                    btn: ['确定', '取消'] //按钮
                }, function (index) {
                    common.json('/admin/delete-comments', {id: data.id}, function (res) {
                        if (res.code === 0) {
                            obj.del();
                            layer.close(index);
                            layer.msg('真的删了', {time: 2000, icon: 1});
                        } else {
                            layer.msg(res.msg, {time: 2000, icon: 5});
                        }
                    });
                });
            }
        });
    });
    exports('admin');
});