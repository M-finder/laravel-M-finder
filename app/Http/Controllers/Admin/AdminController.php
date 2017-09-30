<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use App\Link;
use App\SysConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {

    public function index() {

        $admin = auth()->guard('admin')->user();

        return redirect()->route('dashboard');
    }

    public function dashboard() {
        return view('admin.dashboard');
    }

    public function messages() {
        return view('admin.contact_back');
    }

    public function feedbacks() {
        $per_page = request('limit', 20);
        $feedbacks = Feedback::leftJoin('users', 'users.id', '=', 'feedback.uid')->select('feedback.*', 'users.name')->orderBy('feedback.id', 'desc')->paginate($per_page)->toArray();
        foreach ($feedbacks['data'] as $k => $v) {
            if ($v['mid'] == 1) {
                $feedbacks['data'][$k]['mid'] = '作者认证';
            }
            if ($v['mid'] == 2) {
                $feedbacks['data'][$k]['mid'] = 'BUG反馈';
            }
            if ($v['mid'] == 3) {
                $feedbacks['data'][$k]['mid'] = '友链申请';
            }
            if ($v['mid'] == 4) {
                $feedbacks['data'][$k]['mid'] = '其他';
            }
            if ($v['status'] == 0) {
                $feedbacks['data'][$k]['status'] = '未处理';
            }
            if ($v['status'] == 2) {
                $feedbacks['data'][$k]['status'] = '已处理';
            }
            if ($v['status'] == 1) {
                $feedbacks['data'][$k]['status'] = '拒绝';
            }
        }
        return response()->json(['code' => 0, 'msg' => '操作成功', 'count' => $feedbacks['total'], 'data' => $feedbacks['data']]);
    }

    public function edit_feedback($id = 0) {
        $feedback = Feedback::find($id);
        return view('admin.edit_feedback')->with('feedback', $feedback);
    }

    public function save_feedback() {
        $data = request('data');
        $id = $data['id'];
        $feedback = Feedback::find($id);
        $feedback->status = $data['status'];
        $feedback->reason = $data['reason'];
        $feedback->save();
        return $this->json_response(0, "操作成功", $feedback);
    }

    public function links() {
        return view('admin.links');
    }

    public function get_links() {
        $per_page = request('limit', 20);
        $links = Link::orderBy('id', 'desc')->paginate($per_page)->toArray();

        return response()->json(['code' => 0, 'msg' => '操作成功', 'count' => $links['total'], 'data' => $links['data']]);
    }

    public function edit_links($id = 0) {
        $link = Link::find($id);
        return view('admin.edit_link')->with('link', $link);
    }

    public function save_link() {
        $data = request('data');
        $id = $data['id'];
        if (is_null($id)) {
            unset($data['id']);
            $add = Link::create($data);
            return $this->json_response(0, "操作成功", $add);
        } else {
            $link = Link::find($id);
            $link->name = $data['name'];
            $link->link = $data['link'];
            $link->save();
            return $this->json_response(0, "操作成功", $link);
        }
    }

    public function delete_link() {
        $id = request('id');
        $link = Link::where('id', '=', $id)->first();
        if (is_null($link)) {
            return $this->json_response(1, "链接不存在", 0);
        }
        if ($link->delete()) {
            return $this->json_response(0, "删除成功", 0);
        } else {
            return $this->json_response(1, "删除失败了，刷新再试试", 0);
        }
    }

    public function sysconfig() {
        $sysconfig = SysConfig::find(1);
        return view('admin.sysconfig')->with('sysconfig', $sysconfig);
    }

    public function edit_sysconfig() {
        $data = request('data');
        $sysconfig = SysConfig::find(1);
        $sysconfig->web_name = $data['web_name'];
        $sysconfig->web_title = $data['web_title'];
        $sysconfig->web_keywords = $data['web_keywords'];
        $sysconfig->web_description = $data['web_description'];
        $sysconfig->save();
        return $this->json_response(0, "操作成功", $sysconfig);
    }

    public function infoset() {
        return view('admin.infoset');
    }

    public function password_reset() {
        $oldpwd = request('oldpassword');
        $user = Auth::user();
        if (!Hash::check($oldpwd, $user->password)) {
            return $this->json_response(1, "原始密码错误", 1);
        } else {
            $pwd = Hash::make(request('password'));
            $user->password = $pwd;
            $user->save();
            return $this->json_response(0, "修改成功", 1);
        }
    }

}
