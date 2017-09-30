<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    public function user() {
        return view('admin.users');
    }

    public function users() {
        $per_page = request('limit', 20);
        $kw = request('kw');

        $model = User::orderBy('id', 'desc');
        if (!is_null($kw)) {
            $moedl = $model->where('users.name', 'like', '%' . $kw . '%');
        }
        $users = $model->paginate($per_page)->toArray();
        foreach ($users['data'] as $k => $v) {
            if ($v['is_author'] == 0) {
                $users['data'][$k]['is_author'] = '普通用户';
            }
            if ($v['is_author'] == 1) {
                $users['data'][$k]['is_author'] = '认证作者';
            }
            if ($v['is_author'] == 2) {
                $users['data'][$k]['is_author'] = '管理员';
            }
        }
        return response()->json(['code' => 0, 'msg' => '操作成功', 'count' => $users['total'], 'data' => $users['data']]);
    }

    public function edit_user($id = 0) {
        $user = User::find($id);
        return view('admin.edit_user')->with('user', $user);
    }

    public function save_user() {
        $data = request('data');
        $id = $data['id'];
        $user = User::find($id);
        $user->is_author = $data['is_author'];
        $user->name = $data['name'];
        $user->save();
        return $this->json_response(0, "操作成功", $user);
    }

    public function delete_user() {
        $id = request('id');
        $user = User::where('id', '=', $id)->first();
        if (is_null($user)) {
            return $this->json_response(1, "文章不存在", 0);
        }
        if ($user->delete()) {
            return $this->json_response(0, "删除成功", 0);
        } else {
            return $this->json_response(1, "删除失败了，刷新再试试", 0);
        }
    }

}
