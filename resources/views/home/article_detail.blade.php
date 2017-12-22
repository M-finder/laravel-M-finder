@extends('layouts.index')

@section('content')

<div id="main" class="content homepage" data-aid="{{ $article->id }}">  
    <div class="content-area container ">
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
                        <div class="single-post-inner grap detail-body detail-photo">
                            {!! $article->content !!}
                        </div>
                    </section>

                    <div class="post-actions">
                        <a href='javascript:;' onclick="like_this(this)" data-id="{{ $article->id }}"><i class="layui-icon"  style="font-size: 20px; @if( $article->liked )  color:#bc403e @endif ">&#xe6c6;</i> </a> 
                    </div>
                    <div class="author-field u-textAlignCenter">
                        <img src="{{ isset($article->avatar) ? asset($article->avatar) : '/images/avatar/'.rand(1,11).'.jpg' }}" width="64" height="64" alt="{{ $article->author}}" class="avatar avatar-64 wp-user-avatar wp-user-avatar-64 alignnone photo" />                    
                        <h3>
                            {{ $article->author}} 
                        </h3>
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
                    <ol class="comment-list layui-unselect"  id='comment_list'></ol>
                    <section class="post-content" >
                        <div class="single-post-inner grap">
                            <div id="comment-page" ></div>
                        </div>
                    </section>
                    <div id="respond" class="comment-respond">
                        <h3 id="reply-title" class="comment-reply-title">发表评论 </h3>				
                        <form id="commentform" method="POST"  class="layui-form comment-form" action="/comment" onsubmit="return false;">
                            <input type="hidden"  name="token" id="token" value="{{ $token }}">
                            <input type="hidden"  name="aid"  value="{{ $article->id }}">
                            <div class="comment-form-div">
                                <textarea id="comment_text" cols="45" rows="8" maxlength="65525" aria-required="true" class="layui-textarea"></textarea>
                            </div>
                            <div class="comment-form-div">
                                <button  type="submit" id="submit" class="submit-btn" lay-submit lay-filter="comment">发表评论</button>     
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
