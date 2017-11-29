query_dir = basicUtil.url.getQueryDir();

console.log(query_dir);
dataDraw = function (tpl, option, data) {
    layui.use(['laytpl', 'util'], function () {
        var laytpl = layui.laytpl, util = layui.util;
        laytpl.config({
            open: '<%',
            close: '%>'
        });
        var getTpl = tpl.innerHTML, view = document.getElementById(option);
        laytpl(getTpl).render(data, function (html) {
            view.innerHTML = html;
        });

    });
};
function comments(aid) {
    layui.use(['laypage', 'util'], function () {
        $.post('/comment_search', {page: 1, aid: aid}, function (res) {
            $('#comment-title').text(res.data.total + ' 条评论');
            $('#comment-title').removeClass('layui-hide');
            $('#comment_list').removeClass('layui-hide');
            dataDraw(comment_tpl, 'comment_list', res.data);
            layui.laypage.render({
                elem: 'comment-page'
                , count: res.data.total
                , groups: 3
                , limit: 5
                , jump: function (obj, first) {
                    $.post('/comment_search', {aid: aid, page: obj.curr}, function (res) {
                        if (obj.curr != first) {
                            dataDraw(comment_tpl, 'comment_list', res.data);
                            $("body").animate({scrollTop: $('#comment-title').offset().top});
                        }
                    });
                }
            });
        });
    });
}


$(function () {
    if (query_dir !== '') {
        return false;
    }
    $($(".nav-header-container").children("a").get(0)).addClass('hover');
    var aid = $('#main').data('aid');
    comments(aid);

});




$(function () {
    if (query_dir.indexOf('/category') < 0) {
        return false;
    }
    var id = $('#main').data('cid');
    $($(".nav-header-container").children("a[data-id='" + id + "']")).addClass('hover');

    var total = $('#page').data('total');

    if (total > 20) {
        layui.use(['laypage', 'util'], function () {
            layui.laypage.render({
                elem: 'page'
                , count: total
                , groups: 3
                , limit: 20
                , jump: function (obj, first) {
                    $.post('/category', {type: 1, mid: id, status: 2, page: obj.curr}, function (res) {
                        if (obj.curr != first) {
                            dataDraw(article_tpl, 'article_list', res.data);
                            $("body").animate({scrollTop: $('#article_list').offset().top});
                        }
                    });
                }
            });
        });
    }
});

$(function () {
    if (query_dir.indexOf('/home/article-detail/') < 0) {
        return false;
    }

    var id = $('#main').data('id');
    var aid = $('#main').data('aid');
    $($(".nav-header-container").children("a[data-id='" + id + "']")).addClass('hover');
    comments(aid);
});


$(function () {
    if (query_dir.indexOf('single-page') < 1) {
        return false;
    }
    var id = $('#main').data('id');
    $($(".nav-header-container").children("a[data-id='" + id + "']")).addClass('hover');
});




$(function () {
    if (query_dir !== '/userhome/infoset') {
        return false;
    }
    $($(".layui-nav-item").children("a[href='/userhome/infoset']")).parent('li').addClass('layui-this');
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
    if (query_dir !== '/userhome') {
        return false;
    }
    $($(".layui-nav-item").children("a[href='/userhome']")).parent('li').addClass('layui-this');

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
        $('#search').click(function () {
            table.reload('article_table', {
                url: '/userhome/articles'
                , where: {kw: $('#kw').val()}
            });
        });
    });

});



$(function () {
    if (query_dir !== '/userhome/myarticles') {
        return false;
    }
    $($(".layui-nav-item").children("a[href='/userhome/myarticles']")).parent('li').addClass('layui-this');
    layui.use('table', function () {
        var table = layui.table;
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
                    btn: ['确定', '取消'] //按钮
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
        $('#search').click(function () {
            table.reload('myarticle_table', {
                url: '/userhome/articles'
                , where: {kw: $('#kw').val()}
            });
        });
    });
});

$(function () {
    if (query_dir !== '/userhome/messages') {
        return false;
    }
    $($(".layui-nav-item").children("a[href='/userhome/messages']")).parent('li').addClass('layui-this');
    layui.use('table', function () {
        var table = layui.table;
        layui.use('table', function () {
            var table = layui.table;
        });
    });
});
$(function () {
    if (query_dir !== '/userhome/contact-back') {
        return false;
    }
    layui.use('table', function () {
        var table = layui.table;
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
    });
});