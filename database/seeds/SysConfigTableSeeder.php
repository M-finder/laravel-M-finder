<?php

use Illuminate\Database\Seeder;

class SysConfigTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $sys = new App\SysConfig;
        $sys->web_name = 'M-finder';
        $sys->web_title = '删繁就简,发现更多';
        $sys->web_keywords = 'M-finder博客，laravel，layui，技术分享，原创';
        $sys->web_description = 'M-finder';
        $sys->web_logo = 'images/logo.jpg';
        $sys->web_logo_description = 'logo';
        $sys->save();
    }

}
