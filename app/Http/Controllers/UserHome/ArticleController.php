<?php

namespace App\Http\Controllers\UserHome;

use App\Article;
use App\Menu;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class ArticleController extends AuthController {

    public function articles() {
        $type = request('type');
        $articles = Article::articles()->toArray();
        foreach ($articles['data'] as $k => $v) {
            if ($v['status'] == 0) {
                $articles['data'][$k]['status'] = '未审核';
            }
            if ($v['status'] == 1) {
                $articles['data'][$k]['status'] = '审核失败';
            }
            if ($v['status'] == 2) {
                $articles['data'][$k]['status'] = '已审核';
            }
        }
        return response()->json(['code' => 0, 'msg' => '操作成功', 'count' => $articles['total'], 'data' => $articles['data']]);
    }

    public function new_article() {
        $menus = Menu::select('id', 'name', 'type', 'seo_title', 'seo_describe', 'link')
                        ->where('pid', '=', 0)
                        ->where('is_show', '=', '2')
                        ->where('type', '=', 0)
                        ->get()->toArray();
        return view('userhome.edit_article')
                        ->with('token', md5('Comment' . time()))
                        ->with('menus', $menus);
    }

    public function update_article($id = 0) {
        $menus = Menu::select('id', 'name', 'type', 'seo_title', 'seo_describe', 'link')
                        ->where('pid', '=', 0)
                        ->where('is_show', '=', '2')
                        ->where('type', '=', 0)
                        ->get()->toArray();
        $article = Article::where('id', '=', $id)->first();
        return view('userhome.edit_article')->with('menus', $menus)->with('article', $article);
    }

    public function edit_article() {
        $data = request('data');
        $token = $data['token'];
        unset($data['file']);
        if (is_null($data['id'])) {
            if ($token != Cookie::get('hasArt' . $token)) {
                Cookie::queue('hasArt' . "{$token}", $token, 10);
                unset($data['token'], $data['id']);
                $data['uid'] = Auth::user()->id;
                $user = User::where('id', '=', $data['uid'])->select('is_author')->first();
                $user->increment('article_number');
                if ($user->is_author > 0) {
                    $data['status'] = 2;
                    $data['reason'] = '已发布';
                } else {
                    $data['status'] = 0;
                    $data['reason'] = '待审核';
                }
                $add = Article::create($data);
                return $this->json_response(0, "操作成功", $add);
            } else {
                return $this->json_response(1, "请勿重复提交", 0);
            }
        } else {
            unset($data['token']);
            $article = Article::where('id', '=', $data['id'])->first();
            $article->title = $data['title'];
            $article->content = $data['content'];
            $article->mid = $data['mid'];
            $article->save();
            return $this->json_response(0, "操作成功", $article);
        }
    }

    public function delete_article() {
        $id = request('id');
        $uid = Auth::user()->id;
        $article = Article::where('id', '=', $id)->first();
        if (is_null($article)) {
            return $this->json_response(1, "文章不存在", 0);
        }
        if ($article->uid != $uid) {
            return $this->json_response(1, "干什么呀你，又不是你写的", 0);
        }
        if ($article->delete()) {
            return $this->json_response(0, "删除成功", 0);
        } else {
            return $this->json_response(1, "删除失败了，刷新再试试", 0);
        }
    }

}
