layui.define(['layer', 'laytpl', 'form', 'upload', 'util', 'laypage', 'element', 'layedit'], function (exports) {
    var $ = layui.jquery
            , layer = layui.layer
            , laytpl = layui.laytpl
            , form = layui.form
            , upload = layui.upload
            , util = layui.util
            , laypage = layui.laypage
            , element = layui.element
            , layedit = layui.layedit;

    var gather = {
        json: function (url, data, success) {
            var that = this;
            data = data || {};
            return $.ajax({
                type: 'post',
                dataType: 'json',
                data: data,
                url: url,
                success: function (res) {
                    if (res.code === 0) {
                        success && success(res);
                    } else {
                        var end = function () {
                            if (res.action) {
                                location.href = res.action;
                            }
                        };
                        res.action ? end() : layer.msg(res.msg, {icon: 5, time: 1 * 1000, end: end});
                    }
                }, error: function (e) {
                    layer.msg('请求异常，请重试', {icon: 2, shift: 5});
                }
            });
        }
        , drawData: function (tpl, viewId, data) {
            var getTpl = tpl.innerHTML, view = document.getElementById(viewId);
            laytpl(getTpl).render(data, function (html) {
                view.innerHTML = html;
            });
        }
        , photo: function (target) {
            layer.photos({
                photos: target
                , zIndex: 9999999999
                , anim: -1
            });

        }
        , layedit: function (target) {
            layedit.set({
                uploadImage: {
                    url: '/upload-img' //接口url
                    , type: 'post'
                }
            });

            var index = layedit.build(target, {
                height: 180
                , tool: [
                    'strong' //加粗
                            , 'italic' //斜体
                            , 'underline' //下划线
                            , 'del' //删除线
                            , '|'
                            , 'left' //左对齐
                            , 'center' //居中对齐
                            , 'right' //右对齐
                            , 'code' //代码
                            , 'link' //超链接
                            , 'unlink' //清除链接
                            , 'face' //表情
                            , 'image' //插入图片
                ]
            });
            return index;
        }
        , comment: function (action, aid) {
            gather.json(action, {aid: aid}, function (res) {
                gather.drawData(comment_tpl, 'comment_list', res.data);
                laypage.render({
                    elem: 'comment-page'
                    , count: res.data.total
                    , groups: 3
                    , limit: 5
                    , first: '首页'
                    , last: '尾页'
                    , theme: '#2d57a1'
                    , jump: function (obj, first) {
                        gather.json(action, {page: obj.curr, aid: aid}, function (res) {
                            if (obj.curr != first) {
                                gather.drawData(comment_tpl, 'comment_list', res.data);
                                $("html,body").animate({scrollTop: $('#comment_list').offset().top});
                                gather.photo('.photos');
                            }
                        });
                    }
                });
                gather.photo('.photos');
            });
        }
        , category: function (total, action, id) {
            laypage.render({
                elem: 'page'
                , count: total
                , groups: 3
                , limit: 20
                , theme: '#2d57a1'
                , jump: function (obj, first) {
                    gather.json(action, {type: 1, mid: id, status: 2, page: obj.curr}, function (res) {
                        if (obj.curr != first) {
                            gather.drawData(article_tpl, 'article_list', res.data);
                            $("html,body").animate({scrollTop: $('#article_list').offset().top});
                            gather.photo('.photos');
                        }
                    });
                }
            });
            gather.photo('.photos');
        }
        , getDomain: function () {
            return window.location.href.split('://')[1].split(/[/]+/, 1)[0];
        }
        , getQueryDir: function () {
            return window.location.href.split('://')[1].split('?', 1)[0].replace(this.getDomain(), '').split(/\/$/, 1)[0];
        }
        , getUrl: function () {
            return window.location.href.split('://')[1];
        }
        //新消息通知
        , newmsg: function () {
            var uid = $('#uid').data('uid');
            if (uid) {
                $.post('/userhome/message', {uid: uid}, function (res) {
                    if (res.count > 0) {
                        var msg = $('<a class="nav-message" href="javascript:;" title="您有' + res.count + '条未阅读的消息">' + res.count + '</a>');
                        $('.nav-user').append(msg);
                        msg.on('click', function () {
                            $.post('/userhome/message/read', {}, function (res) {
                                if (res.code === 0) {
                                    location.href = '/userhome/messages';
                                }
                            });
                        });
                    }
                });
            }
            return arguments.callee;
        }
    };


    form.verify({});
    //表单提交
    form.on('submit(*)', function (data) {
        var action = $(data.form).attr('action');
        gather.json(action, data.field, function (res) {
            if (res.code === 0) {
                layer.msg('操作成功', {icon: 5});
            }
            return false;
        });
        return false;
    });
    
    like_this = function (target) {
        $.post('/like', {id: $(target).data('id')}, function (res) {
            if (res.code === 0) {
                $(target).css('color', '#bc403e');
                $('#like_num').text(($('#like_num').text() - 0) + 1);
                layer.tips('Thanks~', target, {tips: [3, '#3595CC'], anim: 4});
            } else {
                layer.tips(res.msg, target, {tips: [3, '#3595CC'], anim: 4});
                return false;
            }
        });
    };

    //右下角固定Bar
    util.fixbar({
        bar1: false
        , bgcolor: 'rgb(0, 150, 136)'
        , click: function (type) {
            if (type === 'bar1') {
                layer.msg('bar1');
            }
        }
    });




    //新消息通知
    gather.newmsg();
    //相册
    gather.photo('.detail-photo');

    exports('common', gather);
});