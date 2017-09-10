<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;

class MenuController extends Controller {

    public function category() {
        return view('admin.category');
    }

    public function categorys() {
        $menus = Menu::menus()->toArray();
        foreach ($menus as $k => $v) {
            if ($v['type'] == 0) {
                $menus[$k]['type'] = '分类';
            }
            if ($v['type'] == 1) {
                $menus[$k]['type'] = '单页';
            }
            if ($v['type'] == 2) {
                $menus[$k]['type'] = '链接';
            }
            if ($v['is_show'] == 1) {
                $menus[$k]['is_show'] = '隐藏';
            }
            if ($v['is_show'] == 2) {
                $menus[$k]['is_show'] = '显示';
            }
        }
        return response()->json(['code' => 0, 'msg' => '操作成功', 'count' => count($menus), 'data' => $menus]);
    }

    public function new_category() {
        return view('admin.edit_category')->with('token',md5('Menu'.time()));
    }

    public function update_category($id = 0) {
        $menu = Menu::where('id', '=', $id)->first();
        return view('admin.edit_category')->with('menu', $menu);
    }

    public function edit_category() {
        $data = request('data');
        $token = $data['token'];
        unset($data['file']);
        if (is_null($data['id'])) {
            if ($token != Cookie::get('hasMenu' . $token)) {
                Cookie::queue('hasMenu' . "{$token}", $token, 10);
                unset($data['token'], $data['id']);
                $data['pid'] = 0;
                $add = Menu::create($data);
                return $this->json_response(0, "操作成功", $add);
            } else {
                return $this->json_response(1, "请勿重复提交", 0);
            }
        } else {
            unset($data['token']);
            $menu = Menu::where('id', '=', $data['id'])->first();
            $menu->name = $data['name'];
            $menu->link = $data['link'];
            $menu->is_show = $data['is_show'];
            $menu->type = $data['type'];
            $menu->content = $data['content'];
            $menu->seo_title = $data['seo_title'];
            $menu->seo_describe = $data['seo_describe'];
            $menu->save();
            return $this->json_response(0, "操作成功", $menu);
        }
    }
    
    public function delete_category() {
        $id = request('id');
        $menu = Menu::where('id', '=', $id)->first();
        if (is_null($menu)) {
            return $this->json_response(1, "分类不存在", 0);
        }
        if ($menu->delete()) {
            return $this->json_response(0, "删除成功", 0);
        } else {
            return $this->json_response(1, "删除失败了，刷新再试试", 0);
        }
    }

}
