<?php

namespace App\Http\Controllers\Home;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller {

    public function index() {
        $article = Article::first_article();
        return view('home.index')
                        ->with('article', $article)
                        ->with('token', md5('Comment' . time()));
    }

}
