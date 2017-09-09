<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->index()->comment('用户ID');
            $table->integer('mid')->index()->comment('分类ID,1-作者认证,2-bug反馈,3-友链申请,4-其他');
            $table->text('content')->comment('文章内容');
            $table->integer('status')->default(0)->comment('状态');
            $table->string('reason')->nullable()->comment('状态原因');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('feedback');
    }

}
