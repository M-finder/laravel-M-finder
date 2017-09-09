<?php

namespace App\Http\Controllers\Home;

use App\Menu;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller {

    public function category($mid = 0) {
        $type = request('type', 0);
        $articles = Article::articles($mid, $type);
        return $type == 1 ?
                $this->json_response(0, "操作成功。", $articles) :
                view('home.category')->with('id', $mid)->with('articles', $articles);
    }
    
    function single_page($id = 0){
        $page = $id != 0 ? Menu::find($id) : '';
        return view('home.single_page')->with('id', $id)->with('page', $page);
    }

}
