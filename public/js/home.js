layui.define(['layer', 'laytpl', 'util', 'laypage', 'element', 'common', 'layedit', 'pjax'], function (exports) {

    var $ = layui.jquery
            , layer = layui.layer
            , laytpl = layui.laytpl
            , form = layui.form
            , upload = layui.upload
            , util = layui.util
            , laypage = layui.laypage
            , element = layui.element
            , common = layui.common
            , layedit = layui.layedit
            , pjax = layui.pjax;

    var index = common.layedit('comment_text');


    form.on('submit(comment)', function (data) {
        data.field['content'] = layedit.getContent(index);
        if (data.field['content'] === '' || $.trim(data.field['content']).length === 0) {
            layer.msg('请输入您的评论内容', {icon: 5});
            return false;
        }
        var action = $(data.form).attr('action');
        common.json(action, data.field, function (res) {
            if (res.code === 0) {
                layer.msg('评论成功', {icon: 6});
                common.comment('/comments', $('#main').data('aid'));
                $("html,body").animate({scrollTop: $('#comment_list').offset().top});
                layedit.setContent(index, '', false);
                $('#token').val(res.data['token']);
            }
            return false;
        });
        return false;
    });

    //回复评论

    recomment = function (target) {
        var uid = target.data('uid');
        var name = target.data('name');
        var val = layedit.getContent(index);
        var aite = '@' + name;

        if (val.indexOf(aite) !== -1) {
            return false;
        }
        layedit.setContent(index, aite + '&nbsp;' + val, false);
        $('#reply_uids').val(uid);
        $("html,body").animate({scrollTop: $('#reply-title').offset().top});
    };



    query_dir = common.getQueryDir();
    console.log(query_dir);

    $(function () {
        if (query_dir !== '') {
            return false;
        }
        var aid = $('#main').data('aid');
        var action = '/comments';
        common.comment(action, aid);
        $(document).on('click', '.comment-reply-link', function () {
            recomment($(this));
        });
    });




    $(function () {
        if (query_dir.indexOf('/category') < 0) {
            return false;
        }
        var id = $('#main').data('cid');
        var total = $('#page').data('total');
        if (total > 20) {
            common.category(total, '/home/category', id);
        }
    });

    $(function () {
        if (query_dir.indexOf('/home/article-detail/') < 0) {
            return false;
        }
        var id = $('#main').data('id');
        var aid = $('#main').data('aid');
        $($(".nav-header-container").children("a[data-id='" + aid + "']")).addClass('hover');
        common.comment('/comments', $('#main').data('aid'));
    });


    $(function () {
        if (query_dir.indexOf('single-page') < 1) {
            return false;
        }
        var id = $('#main').data('id');
        $($(".nav-header-container").children("a[data-id='" + id + "']")).addClass('hover');
    });

    //导航选中
    if (query_dir === '') {
        $($(".nav-header-container").find("a[href='/']")).addClass('hover').siblings().removeClass('hover');
    } else {
        $($(".nav-header-container").find("a[href='" + query_dir + "']")).addClass('hover').siblings().removeClass('hover');
    }

    exports('home');
});





