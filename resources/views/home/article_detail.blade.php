@extends('layouts.home')

@section('content')

<script id="comment_tpl" type="text/html">
    <%# for(var i = 0; i < d.data.length; i++){ %>
    <li id="comment-<% d.data[i].id %>"  class="comment even thread-even depth-1">
        <article class="comment-body" id="comment">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <img src="<% d.data[i].avatar===null ? '/images/avatar/'+parseInt(11*Math.random()) +'.jpg' : d.data[i].avatar %>" width="64" height="64" alt="<% d.data[i].name %>" class="avatar avatar-42 wp-user-avatar wp-user-avatar-42 alignnone photo" />                    						
                    <b class="fn"><% d.data[i].name %></b><span class="says">：</span>					
                </div>
                <div class="comment-metadata">
                    <time datetime="<% d.data[i].creted_at %>"> <% layui.util.timeAgo(d.data[i].created_at) %> </time>
                </div>
            </footer>
            <div class="comment-content">
                <% d.data[i].content %>
            </div>
            <div class="reply">
                <a rel="nofollow" class="comment-reply-link" href="javascript:void(0)" onclick="jump_comment(this)" data-uid="<% d.data[i].uid %>" data-name="<% d.data[i].name %>">回复</a>
            </div>
        </article>
    </li>
    <%# } %>
</script>

<div id="main" class="content homepage" data-id="{{ $id }}" data-aid="{{ $article->id }}">  
    <div class="content-area container">
        <div class="site-content" id="article_content">
            <div class="content-area container">
                <header class="entry-header page-header">
                    <h1 class="entry-title page-title">{{ $article->title }}</h1>		
                    <div class="entry-meta">
                        <time class="entry-date published updated" datetime="{{ $article->created_at }}">{{ $article->created_at }}</time>			
                        <span class="separator">/</span>
                        {{ $article->read }} 阅		
                        <span class="separator" >/</span>
                        <span id='like_num'>{{ $article->like }}</span> 赞		
                    </div>
                </header>
                <div class="site-content">
                    <section class="post-content">
                        <div class="single-post-inner grap detail-body photos">
                            {!! $article->content !!}
                        </div>
                    </section>

                    <div class="post-actions">
                        <a href='javascript:;' onclick="like_this(this)" data-id="{{ $article->id }}"><i class="layui-icon"  style="font-size: 20px; @if( $article->liked )  color:#bc403e @endif ">&#xe6c6;</i> </a> 
                    </div>
                    <div class="author-field u-textAlignCenter">
                        <img src="{{ isset($article->avatar) ? asset($article->avatar) : '/images/avatar/'.rand(1,11).'.jpg' }}" width="64" height="64" alt="{{ $article->author}}" class="avatar avatar-64 wp-user-avatar wp-user-avatar-64 alignnone photo" />                    
                        <h3>{{ $article->author}}</h3>
                            @if($article->author_level==2)
                            <span class="layui-badge-rim layui-bg-orange">管理员 </span>
                            @elseif($article->author_level==1)
                            <span class="layui-badge-rim layui-bg-blue">发布者</span>
                            @endif
                        <p>{{ $article->sign}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-content" style='padding-top:5px;'>
            <div class="content-area container">
                <div id="comments" class="comments-area">
                    <h2 class="comments-title layui-hide " id='comment-title'> 条评论</h2>     
                    <h2 class="comments-title layui-hide " id='comment-title' style="text-align: center">消灭零回复</h2>        
                    <ol class="comment-list layui-hide "  id='comment_list'>
         
                    </ol>
                    <section class="post-content" >
                        <div class="single-post-inner grap">
                            <div id="comment-page" data-total=""></div>
                        </div>
                    </section>
                    <div id="respond" class="comment-respond">
                        <h3 id="reply-title" class="comment-reply-title">发表评论 </h3>				
                        <form id="commentform" class="comment-form">
                            <p class="comment-form-comment">
                                <textarea id="comment_text"  cols="45" rows="8" maxlength="65525" aria-required="true" class="layui-textarea fly-editor"></textarea>
                                <input type="hidden" name="token" id="token" value="{{ $token }}">
                            </p>
                            <p class="form-submit">
                                <input type="button"  onclick="submit_comment()" id="submit" class="submit-btn" value="发表评论"> 
                            </p>				
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
