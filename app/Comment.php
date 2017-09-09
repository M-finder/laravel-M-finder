<?php

namespace App;

use App\Article;
use App\Message;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class Comment extends Model {
    #评论搜索

    public static function search($article_id) {
        $per_page = request('per_page', 5);
        $comments = Comment::select('comments.*', 'users.name', 'users.avatar')
                ->leftJoin('users', 'users.id', '=', 'comments.uid')
                ->where('comments.aid', '=', $article_id)
                ->orderBy('id', 'asc')
                ->paginate($per_page);
        return $comments;
    }

    public static function new_comment($token) {
        Cookie::queue('hasCom' . "{$token}", $token, 10);
        $inputs['aid'] = request('aid');
        $inputs['reply_uids'] = request('reply_uids', null);
        $inputs['content'] = request('val');
        $inputs['uid'] = Auth::user()->id;
        $inputs['status'] = 0;
        
        $article = Article::where('id', '=', $inputs['aid'])->select('uid','title')->first();
        if ($inputs['reply_uids'] != null) {
            $ids = array_filter(explode(",", $inputs['reply_uids']));
            if ($ids) {
                foreach ($ids as $id) {
                    $message['uid'] = $id;
                    $message['status'] = 0;
                    $message['type'] = 0;
                    $message['title'] = '<a>' . Auth::user()->name . '</a>' . '在<a href="/detail/' . $id . '" target="_blade">' . $article->title . '</a>中回复了你';
                    $message['content'] = $inputs['content'];
                    Message::create($message);
                }
            }
        }


        $message['status'] = 0;
        $message['type'] = 0;
        $message['title'] = '<a>' . Auth::user()->name . '</a>' . '在<a href="/detail/' . $article->id . '" target="_blade">' . $article->title . '</a>中回复了你';
        $message['content'] = $inputs['content'];
        $message['uid'] = $article->uid;
        $new_comment = Comment::create($inputs);
        Message::create($message);
        return $new_comment;
    }

}
