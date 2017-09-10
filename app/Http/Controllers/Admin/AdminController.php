<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        // $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $admin = auth()->guard('admin')->user();

        return redirect()->route('dashboard');
    }

   public function dashboard() {
       return view('admin.dashboard');
   }
   
   public function messages(){
       return view('admin.contact_back');
   }
   
   public function feedbacks() {
        $per_page = request('per_page', 20);
        $feedbacks = Feedback::orderBy('id','desc')->paginate($per_page)->toArray();
        foreach($feedbacks['data'] as $k=>$v){
            if($v['mid']==1){
                $feedbacks['data'][$k]['mid'] = '作者认证';
            }
            if($v['mid']==2){
                $feedbacks['data'][$k]['mid'] = 'BUG反馈';
            }
            if($v['mid']==3){
                $feedbacks['data'][$k]['mid'] = '友链申请';
            }
            if($v['mid']==4){
                $feedbacks['data'][$k]['mid'] = '其他';
            }
            if($v['status']==0){
                $feedbacks['data'][$k]['status'] = '未处理';
            }
            if($v['status']==2){
                $feedbacks['data'][$k]['status'] = '已处理';
            }
            if($v['status']==1){
                $feedbacks['data'][$k]['status'] = '拒绝';
            }
        }
        return response()->json(['code' => 0, 'msg' => '操作成功', 'count' => $feedbacks['total'], 'data' => $feedbacks['data']]);
    }
    

    public function edit_feedback($id=0){
        $feedback = Feedback::find($id);
        return view('admin.edit_feedback')->with('feedback',$feedback);
    }
    public function save_feedback(){
        $data = request('data');
        $id = $data['id'];
        $feedback = Feedback::find($id);
        $feedback->status = $data['status'];
        $feedback->reason = $data['reason'];
        $feedback->save();
        return $this->json_response(0, "操作成功", $feedback);
    }
}
