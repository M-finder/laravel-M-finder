<?php

namespace App;

use Illuminate\Support\Facades\Cookie;

class Article extends Model {

    const ARTICLE_STATUS_DEFAULT = 0;
    const ARTICLE_STATUS_FAILD = 1;
    const ARTICLE_STATUS_SUCCESS = 2;
    const ARTICLE_FAILD_REASON = '发布内容不符合规范';

    public static function common() {
        $article = Article::leftJoin('users', 'users.id', '=', 'articles.uid')
                ->leftJoin('menus', 'menus.id', '=', 'articles.mid')
                ->select('articles.*', 'users.name as author', 'users.sign', 'users.avatar', 'users.is_author as author_level', 'menus.name as menu')
                ->orderBy('articles.id', 'desc');
        return $article;
    }

    public static function first_article() {
        $article = self::common()->where('status','=',2)->first();
        #已读cookie
        if (!Cookie::has('read' . $article->id) && !is_null($article)) {
            $article->increment('read');
            Cookie::queue('read' . "{$article->id}", 'readed', 10);
        }
        #是否已赞
        if (Cookie::has('like' . $article->id) && !is_null($article)) {
            $article->liked = 1;
        }
        return $article;
    }

    public static function articles($mid=0) {
        $per_page = request('per_page', 20);
        $model = self::common();
        
        $uid = request('uid');
        $kw = request('kw');
        $status = request('status',2);
        
        if (!is_null($uid) && $uid != 0) {
            $model = $model->where('articles.uid', '=', $uid);
        }
        if (!is_null($status) && $status != 'all') {
            $model = $model->where('articles.status', '=', $status);
        }
        if (!is_null($mid) && $mid != 0) {
            $model = $model->where('articles.mid', '=', $mid);
        }
        if (!is_null($kw)) {
            $model = $model->where('articles.title', 'like', '%'.$kw.'%');
        }

        $articles = $model->paginate($per_page);
        return $articles;
    }

    public static function article_detail($aid) {
        $model = self::common();
        $article = $model->where('articles.id', '=', $aid)->first();
        #已读cookie
        if (!Cookie::has('read' . $article->id) && !is_null($article)) {
            $article->increment('read');
            Cookie::queue('read' . "{$article->id}", 'readed', 10);
        }
        #是否已赞
        if (Cookie::has('like' . $article->id) && !is_null($article)) {
            $article->liked = 1;
        }
        return $article;
    }

}
