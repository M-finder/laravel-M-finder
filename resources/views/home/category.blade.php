@extends('home.home')

@section('content')

<script id="article_tpl" type="text/html">
    <%# for(var i = 0; i < d.data.length; i++){  %>
    <article class="post-item">
        <div class="info-mask">
            <div class="mask-wrapper">
                <h2 class="post-title layui-elip">
                    <a href="/home/article-detail/<% d.data[i].id %>" title="<% d.data[i].title %>"><% d.data[i].title %></a>
                </h2>
                <div class="post-info"><span class="post-time"><time><% layui.util.timeAgo(d.data[i].created_at)  %></time></span>
                    <span class="middotDivider"></span>
                    <span class="post-tags"><% d.data[i].menu %></span>
                    <span class="middotDivider"></span>
                    <span class="post-author">Author - <% d.data[i].author %></span>
                    <span class="middotDivider"></span>
                    <span class="post-read"><i class="iconfont icon-liulanyanjing"></i> - <% d.data[i].read %></span>
                    <span class="middotDivider"></span>
                    <span class="post-like"><i class="layui-icon" >&#xe6c6;</i> - <% d.data[i].like %></span>
                </div>
            </div>
        </div>
    </article>
    <%# } %>
</script>

<div id="main" class="content homepage" data-cid="{{ $id }}">    
    <div class="content-area container">
        <div class="site-content" id="article_list">
            @foreach($articles as $article)
            <article class="post-item">
                <div class="info-mask">
                    <div class="mask-wrapper">
                        <h2 class="post-title layui-elip">
                            <a href="/home/article-detail/{{ $article->id }}" title="{{ $article->title }}">{{ $article->title }}</a>
                        </h2>
                        <div class="post-info"><span class="post-time"><time>{{ $article->created_at }}</time></span>
                            <span class="middotDivider"></span>
                            <span class="post-tags">{{ $article->menu }}</span>
                            <span class="middotDivider"></span>
                            <span class="post-author">Author - {{ $article->author }}</span>
                            <span class="middotDivider"></span>
                            <span class="post-read"><i class="iconfont icon-liulanyanjing"></i> - {{ $article->read }}</span>
                            <span class="middotDivider"></span>
                            <span class="post-like"><i class="layui-icon" >&#xe6c6;</i> - {{ $article->like }}</span>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach

            @if(count($articles)==0)
            <article class="post-item">
                <div class="info-mask">
                    <div class="mask-wrapper">
                        <div class="post-info" style="text-align:center;margin-bottom:50px;">
                            <i class="layui-icon" style="line-height: 200px;font-size: 200px; color: #2F4056;">&#xe69c;</i>   
                        </div>
                        <div class="post-info" style="text-align:center;margin-bottom:50px;">
                            <span style="text-align: center">
                                本栏目暂无数据
                            </span>
                            <span class="layui-badge-dot" style="margin-left:20px;"></span>
                            <span class="layui-badge-dot layui-bg-orange"></span>
                            <span class="layui-badge-dot layui-bg-green"></span>
                            <span class="layui-badge-dot layui-bg-cyan"></span>
                            <span class="layui-badge-dot layui-bg-blue"></span>
                            <span class="layui-badge-dot layui-bg-black"></span>
                            <span class="layui-badge-dot layui-bg-gray"></span>
                        </div>
                    </div>
                </div>
            </article>
            @endif
        </div>
    </div>
</div>
<section class="post-content">
    <div class="single-post-inner grap">
        <div id="page" data-total="{{ $articles->total() }}"></div>
    </div>
</section>

@endsection