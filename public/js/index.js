/**
 
 @Name: Fly社区主入口
 
 */
        layui.define(['layer', 'laytpl', 'form', 'upload', 'util'], function (exports) {

            var $ = layui.jquery
                    , layer = layui.layer
                    , laytpl = layui.laytpl
                    , form = layui.form
                    , util = layui.util
                    , upload = layui.upload
                    , device = layui.device()
                    , element = layui.element

            layui.focusInsert = function (obj, str) {
                var result, val = obj.value;
                obj.focus();
                if (document.selection) { //ie
                    result = document.selection.createRange();
                    document.selection.empty();
                    result.text = str;
                } else {
                    result = [val.substring(0, obj.selectionStart), str, val.substr(obj.selectionEnd)];
                    obj.focus();
                    obj.value = result.join('');
                }
            };

            laytpl.config({
                open: '<%',
                close: '%>'
            });

            var gather = {

                //Ajax
                json: function (url, data, success, options) {
                    var that = this;
                    options = options || {};
                    data = data || {};
                    return $.ajax({
                        type: options.type || 'post',
                        dataType: options.dataType || 'json',
                        data: data,
                        url: url,
                        success: function (res) {
                            if (res.status === 0) {
                                success && success(res);
                            }
                        }, error: function (e) {
                            options.error || layer.msg('请求异常，请重试', {shift: 6});
                        }
                    });
                }

                //将普通对象按某个key排序
                , sort: function (data, key, asc) {
                    var obj = JSON.parse(JSON.stringify(data));
                    var compare = function (obj1, obj2) {
                        var value1 = obj1[key];
                        var value2 = obj2[key];
                        if (value2 < value1) {
                            return -1;
                        } else if (value2 > value1) {
                            return 1;
                        } else {
                            return 0;
                        }
                    };
                    obj.sort(compare);
                    if (asc)
                        obj.reverse();
                    return obj;
                }

                //计算字符长度
                , charLen: function (val) {
                    var arr = val.split(''), len = 0;
                    for (var i = 0; i < val.length; i++) {
                        arr[i].charCodeAt(0) < 299 ? len++ : len += 2;
                    }
                    return len;
                }

                , form: {}

                //简易编辑器
                , layEditor: function (options) {
                    var html = '<div class="fly-edit">'
                            + '<span type="face" title="插入表情"><i class="iconfont icon-biaoqing"></i>表情</span>'
                            + '<span type="picture" title="插入图片：img[src]"><i class="iconfont icon-tupian"></i>图片</span>'
                            + '<span type="href" title="超链接格式：a(href)[text]"><i class="iconfont icon-lianjie"></i>链接</span>'
                            + '<span type="code" title="插入代码"><i class="iconfont icon-daima"></i>代码</span>'
                            + '<span type="yulan" title="预览"><i class="iconfont icon-yulan"></i>预览</span>'
                            + '</div>';
                    var log = {}, mod = {
                        picture: function (editor) { //插入图片
                            layer.open({
                                type: 1
                                , id: 'fly-jie-upload'
                                , title: '插入图片'
                                , area: 'auto'
                                , shade: false
                                , area: '465px'
                                , skin: 'layui-layer-border'
                                , content: ['<ul class="layui-form layui-form-pane" style="margin: 20px;">'
                                            , '<li class="layui-form-item">'
                                            , '<label class="layui-form-label">URL</label>'
                                            , '<div class="layui-input-inline">'
                                            , '<input required name="image" placeholder="支持直接粘贴远程图片地址" value="" class="layui-input">'
                                            , '</div>'
                                            , '<button type="button" class="layui-btn layui-btn-primary" id="uploadImg"><i class="layui-icon"></i>上传图片</button>'
                                            , '</li>'
                                            , '<li class="layui-form-item" style="text-align: center;">'
                                            , '<button type="button" lay-submit lay-filter="uploadImages" class="layui-btn">确认</button>'
                                            , '</li>'
                                            , '</ul>'].join('')
                                , success: function (layero, index) {
                                    var image = layero.find('input[name="image"]');

                                    upload.render({
                                        url: '/upload/img'
                                        , elem: '#uploadImg'
                                        , accept: 'file' //普通文件
                                        , exts: 'png|jpg|gif|jpeg|PNG|GIF|JPG|JPEG' //只允许上传压缩文件
                                        , done: function (res) {
                                            if (res.code == 0) {
                                                image.val(res.data.src);
                                            } else {
                                                layer.msg(res.msg, {icon: 5});
                                            }
                                        }
                                    });

                                    form.on('submit(uploadImages)', function (data) {
                                        var field = data.field;
                                        if (!field.image)
                                            return image.focus();
                                        layui.focusInsert(editor[0], 'img[' + field.image + '] ');
                                        layer.close(index);
                                    });
                                }
                            });
                        }
                        , face: function (editor, self) { //插入表情
                            var str = '', ul, face = gather.faces;
                            for (var key in face) {
                                str += '<li title="' + key + '"><img src="' + face[key] + '"></li>';
                            }
                            str = '<ul id="LAY-editface" class="layui-clear">' + str + '</ul>';
                            layer.tips(str, self, {
                                tips: 3
                                , time: 0
                                , skin: 'layui-edit-face'
                            });
                            $(document).on('click', function () {
                                layer.closeAll('tips');
                            });
                            $('#LAY-editface li').on('click', function () {
                                var title = $(this).attr('title') + ' ';
                                layui.focusInsert(editor[0], 'face' + title);
                            });
                        }
                        , href: function (editor) { //超链接
                            layer.prompt({
                                title: '请输入合法链接'
                                , shade: false
                            }, function (val, index, elem) {
                                if (!/^http(s*):\/\/[\S]/.test(val)) {
                                    layer.tips('这根本不是个链接，不要骗我。', elem, {tips: 1})
                                    return;
                                }
                                layui.focusInsert(editor[0], ' a(' + val + ')[' + val + '] ');
                                layer.close(index);
                            });
                        }
                        , code: function (editor) { //插入代码
                            layer.prompt({
                                title: '请贴入代码'
                                , formType: 2
                                , maxlength: 10000
                                , shade: false
                                , area: ['830px', '390px']
                            }, function (val, index, elem) {
                                layui.focusInsert(editor[0], '[pre]\n' + val + '\n[/pre]');
                                layer.close(index);
                            });
                        }
                        , yulan: function (editor) { //预览
                            var content = editor.val();

                            content = /^\{html\}/.test(content)
                                    ? content.replace(/^\{html\}/, '')
                                    : gather.content(content);

                            layer.open({
                                type: 1
                                , title: '预览'
                                , area: ['100%', '100%']
                                , scrollbar: false
                                , content: '<div class="detail-body" style="margin:20px;">' + content + '</div>'
                            });
                        }
                    };

                    layui.use('face', function (face) {
                        options = options || {};
                        gather.faces = face;
                        $(options.elem).each(function (index) {
                            var that = this, othis = $(that), parent = othis.parent();
                            parent.prepend(html);
                            parent.find('.fly-edit span').on('click', function (event) {
                                var type = $(this).attr('type');
                                mod[type].call(that, othis, this);
                                if (type === 'face') {
                                    event.stopPropagation()
                                }
                            });
                        });
                    });

                }

                , escape: function (html) {
                    return String(html || '').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
                            .replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&quot;');
                }
                //新消息通知
                , newmsg: function () {
                    var uid = $('#uid').data('uid');
                    if (uid) {
                        gather.json('/home/message', {uid: uid}, function (res) {
                            if (res.count > 0) {
                                var msg = $('<a class="nav-message" href="javascript:;" title="您有' + res.count + '条未阅读的消息">' + res.count + '</a>');
                                $('.nav-user').append(msg);
                                msg.on('click', function () {
                                    gather.json('/message/read', {}, function (res) {
                                        if (res.code === 0) {
                                            location.href = '/messageread';
                                        }
                                    });
                                });
                            }
                        });
                    }
                    return arguments.callee;
                }

                //内容转义
                , content: function (content) {
                    //支持的html标签
                    var html = function (end) {
                        return new RegExp('\\[' + (end || '') + '(pre|div|table|thead|th|tbody|tr|td|ul|li|ol|li|dl|dt|dd|h2|h3|h4|h5)\\]\\n*', 'g');
                    };
                    content = gather.escape(content || '') //XSS
                            .replace(/img\[([^\s]+?)\]/g, function (img) {  //转义图片
                                return '<img src="' + img.replace(/(^img\[)|(\]$)/g, '') + '">';
                            }).replace(/@(\S+)(\s+?|$)/g, '@<a href="javascript:;" class="fly-aite">$1</a>$2') //转义@
                            .replace(/face\[([^\s\[\]]+?)\]/g, function (face) {  //转义表情
                                var alt = face.replace(/^face/g, '');
                                return '<img alt="' + alt + '" title="' + alt + '" src="' + gather.faces[alt] + '">';
                            }).replace(/a\([\s\S]+?\)\[[\s\S]*?\]/g, function (str) { //转义链接
                        var href = (str.match(/a\(([\s\S]+?)\)\[/) || [])[1];
                        var text = (str.match(/\)\[([\s\S]*?)\]/) || [])[1];
                        if (!href)
                            return str;
                        var rel = /^(http(s)*:\/\/)\b(?!(\w+\.)*(sentsin.com|layui.com))\b/.test(href.replace(/\s/g, ''));
                        return '<a href="' + href + '" target="_blank"' + (rel ? ' rel="nofollow"' : '') + '>' + (text || href) + '</a>';
                    }).replace(html(), '\<$1\>').replace(html('/'), '\</$1\>') //转移代码
                            .replace(/\n/g, '<br>') //转义换行   
                    return content;
                }};

            //相册
            layer.photos({
                photos: '.photos'
                , zIndex: 9999999999
                , anim: -1
            });

            //发送激活邮件
            gather.activate = function (email) {
                gather.json('/api/activate/', {}, function (res) {
                    if (res.status === 0) {
                        layer.alert('已成功将激活链接发送到了您的邮箱，接受可能会稍有延迟，请注意查收。', {
                            icon: 1
                        });
                    }
                    ;
                });
            };
            $('#LAY-activate').on('click', function () {
                gather.activate($(this).attr('email'));
            });

            gather.newmsg();

            //回复评论
            jump_comment = function (target) {
                var uid = $(target).data('uid');
                var name = $(target).data('name');
                var val = $('#comment_text').val();
                var aite = '@' + name;

                $('#comment_text').focus();
                if (val.indexOf(aite) != -1) {
                    return false;
                }
                $('#comment_text').val(aite + ' ' + val);
                if ($('#commentform').attr('data-uid')) {
                    $('#commentform').attr('data-uid', $('#commentform').attr('data-uid') + ',' + uid);
                } else {
                    $('#commentform').attr('data-uid', ',' + uid);
                }
            }


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

            //发布
            submit_comment = function () {
                var content = $('#comment_text').val();
                content = /^\{html\}/.test(content)
                        ? content.replace(/^\{html\}/, '')
                        : gather.content(content);
                var aid = $('#main').data('aid');
                var reply_uids = $('#commentform').attr('data-uid');
                var token = $('#token').val();
                
                if (content == '' || $.trim(content).length === 0) {
                    layer.msg('请输入评论内容', {icon: 5});
                } else {
                    $.post('/comment', {token:token,aid: aid, reply_uids: reply_uids, val: content}, function (res) {
                        if (res.code == 0) {
                            layer.msg('评论成功', {icon: 1});
                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        } else {
                            layer.msg(res.msg, {icon: 5});
                            return false;
                        }
                    });
                }
            }

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




            //加载特定模块
            if (layui.cache.page && layui.cache.page !== 'index') {
                var extend = {};
                extend[layui.cache.page] = layui.cache.page;
                layui.extend(extend);
                layui.use(layui.cache.page);
            }



            //加载IM
            if (!device.android && !device.ios) {
                //layui.use('im');
            }

            //加载编辑器
            gather.layEditor({
                elem: '.fly-editor'
            });

            //右下角固定Bar
            util.fixbar({
                bar1: false
                , click: function (type) {
                    if (type === 'bar1') {
                        layer.msg('bar1');
                    }
                }
            });


            var times = $('time').each(function (index, item) {
                $(item).text(util.timeAgo($(item).text()));
            });

            //手机设备的简单适配
            var treeMobile = $('.site-tree-mobile')
                    , shadeMobile = $('.site-mobile-shade')

            treeMobile.on('click', function () {
                $('body').addClass('site-mobile');
            });

            shadeMobile.on('click', function () {
                $('body').removeClass('site-mobile');
            });

            //图片懒加载
            /*
             layui.use('flow', function(flow){
             flow.lazyimg();
             });*/


            exports('fly', gather);

        });

