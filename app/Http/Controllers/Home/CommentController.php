<?php

namespace App\Http\Controllers\Home;

use App\Comment;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {
    #评论数据

    public function comment_search() {
        $aid = request('aid', 0);
        $article = Article::find($aid);
        if (is_null($article)) {
            return $this->json_response(1, "数据获取失败。", 0);
        }
        $comments = Comment::search($article->id);
        return $this->json_response(0, "操作成功。", $comments);
    }

    #评论

    public function comment() {
        if (Auth::guest()) {
            return $this->json_response(1, "请先登录", 0);
        } else {
            $token = request('token');
            if ($token != Cookie::get('hasCom' . $token)) {
                $new_comment = Comment::new_comment($token);
                $new_comment->token =  md5('Comment' . time());
            } else {
                return $this->json_response(1, "请勿重复提交", 0);
            }
            return $this->json_response(0, "操作成功", $new_comment);
        }
    }

}
