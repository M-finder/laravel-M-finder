<?php

namespace App;

use App\Menu;

class Menu extends Model {

    public static function common() {
        return $morel = Menu::orderBy('id', 'asc');
    }

    public static function menus() {
        $model = self::common();
        $kw = request('kw');

        if (!is_null($kw)) {
            $model = $model->where('menus.name', 'like', '%' . $kw . '%');
        }

        return $menus = $model->get();
    }

}
