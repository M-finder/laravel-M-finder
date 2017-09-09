<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->index()->comment('用户ID');
            $table->integer('mid')->index()->comment('文章分类ID');
            $table->string('title')->comment('文章标题');
            $table->text('content')->comment('文章内容');
            $table->integer('read')->default(0)->comment('阅读量');
            $table->integer('like')->default(0)->comment('赞赏量');
            $table->integer('status')->default(0)->comment('发布状态,0-未审核,1-发布失败,2-发布成功');
            $table->string('reason')->nullable()->comment('发布失败原因');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
