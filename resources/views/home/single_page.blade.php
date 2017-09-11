@extends('layouts.home')

@section('content')

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
                        <div class="single-post-inner grap photos">
                            {!! $page['content'] !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
