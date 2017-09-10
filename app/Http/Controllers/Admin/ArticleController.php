<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller {

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
    
    public function update_article($id = 0) {
        $menus = Menu::select('id', 'name', 'type', 'seo_title', 'seo_describe', 'link')
                        ->where('pid', '=', 0)
                        ->where('is_show', '=', '2')
                        ->where('type', '=', 0)
                        ->get()->toArray();
        $article = Article::where('id', '=', $id)->first();
        return view('admin.edit_article')->with('menus', $menus)->with('article', $article);
    }
    

    public function edit_article() {
        $data = request('data');
        unset($data['token'],$data['file']);
        $article = Article::where('id', '=', $data['id'])->first();
        $article->title = $data['title'];
        $article->content = $data['content'];
        $article->mid = $data['mid'];
        $article->save();
        return $this->json_response(0, "操作成功", $article);
    }

    public function delete_article() {
        $id = request('id');
        $article = Article::where('id', '=', $id)->first();
        if (is_null($article)) {
            return $this->json_response(1, "文章不存在", 0);
        }
        if ($article->delete()) {
            return $this->json_response(0, "删除成功", 0);
        } else {
            return $this->json_response(1, "删除失败了，刷新再试试", 0);
        }
    }

}
