<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $menu = new App\Menu;
        $menu->pid = '0';
        $menu->name = '博客首页';
        $menu->type = '2';
        $menu->is_show = '2';
        $menu->link = '/';
        $menu->content = '';
        $menu->save();
        
        $menu = new App\Menu;
        $menu->pid = '0';
        $menu->name = '闲言赘语';
        $menu->type = '0';
        $menu->is_show = '2';
        $menu->link = '';
        $menu->content = '';
        $menu->save();
        
        $menu = new App\Menu;
        $menu->pid = '0';
        $menu->name = '技术讨论';
        $menu->type = '0';
        $menu->is_show = '2';
        $menu->link = '';
        $menu->content = '';
        $menu->save();
        
        $menu = new App\Menu;
        $menu->pid = '0';
        $menu->name = '关于';
        $menu->type = '1';
        $menu->is_show = '2';
        $menu->link = '';
        $menu->content = '这里是关于我们,写点自我介绍吧';
        $menu->save();
    }

}
