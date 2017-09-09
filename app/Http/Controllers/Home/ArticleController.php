<?php

namespace App\Http\Controllers\Home;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class ArticleController extends Controller {

    public function article_detail($id = 0) {
        $article = Article::article_detail($id);
        $mid = is_null($article['mid']) ? 0 : $article->mid;
        return view('home.article_detail')
                        ->with('id', $mid )
                        ->with('article', $article)
                        ->with('token', md5('Comment' . time()));
    }
    
    public function like(){
        $aid = request('id');
        if (!Cookie::has('like' . $aid)) {
            Article::where('id', '=', $aid)->first()->increment('like');
            Cookie::queue('like' . "{$aid}", 'liked', 10);
            return $this->json_response(0, "操作成功。", 1);
        }
        return $this->json_response(1, "点过赞了，歇会儿再来~", 0);
    }
    
    

}
