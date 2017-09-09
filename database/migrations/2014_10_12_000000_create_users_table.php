<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->index()->comment('用户名称');
            $table->string('email')->unique()->comment('用户邮箱');
            $table->string('password');
            $table->string('sign', 50)->nullable()->comment('签名');
            $table->string('avatar')->nullable()->comment('头像');
            $table->integer('is_author')->default(0)->commetn('发布者认证,0-默认,1-发布者,2-管理员');
            $table->enum('gender',['男', '女'])->default('男');
            $table->integer('article_number')->default(0)->comment('已发布文章数量');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
