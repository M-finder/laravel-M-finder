<?php

namespace App\Providers;

use App\Link;
use App\Menu;
use App\SysConfig;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191);

        view()->composer(['layouts.home', 'layouts.index','layouts.userhome','layouts.admin'], function($view) {
            $links = Link::orderBy('id', 'desc')->get();
            $web_info = SysConfig::first();
            $menus = Menu::select('id', 'name', 'type',  'link')->where('pid', '=', 0)->where('is_show', '=', '2')->get();
            $view->with(['links' => $links, 'web_info' => $web_info, 'menus' => $menus]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
