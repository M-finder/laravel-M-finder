<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function comments(){
        return view('admin.comments');
    }
    public function get_comments(){
        $per_page = request('per_page', 20);
        $comments = Comment::leftJoin('articles','articles.id','=','comments.aid')
                ->leftjoin('users','users.id','=','comments.uid')
                ->select('articles.title','comments.*','users.name')
                ->orderBy('comments.id','desc')->paginate($per_page)->toArray();
        return response()->json(['code' => 0, 'msg' => '操作成功', 'count' => $comments['total'], 'data' => $comments['data']]);
    }
    
    public function delete_comments(){
        $id = request('id');
        $comment = Comment::where('id', '=', $id)->first();
        if (is_null($comment)) {
            return $this->json_response(1, "评论不存在", 0);
        }
        if ($comment->delete()) {
            return $this->json_response(0, "删除成功", 0);
        } else {
            return $this->json_response(1, "删除失败了，刷新再试试", 0);
        }
    }
}
