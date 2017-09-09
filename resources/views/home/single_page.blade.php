@extends('home.home')

@section('content')

<script id="comment_tpl" type="text/html">
    <%# for(var i = 0; i < d.data.length; i++){ %>
    <li id="comment-142" class="comment even thread-even depth-1">
        <article class="comment-body" id="comment">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <img src="/images/avatar/<% d.data[i].avatar===null ? parseInt(11*Math.random()) +'.jpg' : d.data[i].avatar %>" width="64" height="64" alt="<% d.data[i].name %>" class="avatar avatar-42 wp-user-avatar wp-user-avatar-42 alignnone photo" />                    						
                    <b class="fn"><% d.data[i].name %></b><span class="says">：</span>					
                </div>
                <div class="comment-metadata">
                    <time datetime="<% d.data[i].creted_at %>"> <% layui.util.timeAgo(d.data[i].created_at) %> </time>
                </div>
            </footer>
            <div class="comment-content">
                <p><%#  if(d.data[i].reply) { for(var k = 0; k < d.data[i].reply.length; k++){ %> @<% d.data[i].reply[k].name  %> <%# } } %> <% d.data[i].content %></p>
            </div>
            <div class="reply">
                <a rel="nofollow" class="comment-reply-link" href="javascript:void(0)" onclick="jump_comment(this)" data-uid="<% d.data[i].uid %>" data-name="<% d.data[i].name %>">回复</a>
            </div>
        </article>
    </li>
    <%# } %>
</script>

<div id="main" class="content homepage" data-id="{{ $id }}" data-aid="">  
    <div class="content-area container">
        <div class="site-content" id="article_content">
            <div class="content-area container">
                <header class="entry-header page-header">
                    <h1 class="entry-title page-title">{{ $page['name'] }}</h1>		
                    <div class="entry-meta">
                        <time class="entry-date published updated" datetime="{{ $page['created_at'] }}">{{ $page['created_at'] }}</time>			
                       
                    </div>
                </header>
                <div class="site-content">
                    <section class="post-content">
                        <div class="single-post-inner grap">
                            {{ $page['content'] }}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
