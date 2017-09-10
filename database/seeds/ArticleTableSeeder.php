<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $article = new App\Article;
        $article->uid = '1';
        $article->mid = '2';
        $article->title = '我想做一个有情调的人';
        $article->content = '真的。';
        $article->read = '0';
        $article->like = '0';
        $article->status = '2';
        $article->save();
    }

}
