<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    //登陆
    public function login(){
        if ($input = input::all()){
            $code = new \code();
            $_code = $code ->get();
            if ( strtoupper($input['code']) !=   strtoupper($_code)){
                return back() -> with('msg','验证码错误！');
            }else{
                if ( empty($input['user_name']) || empty($input['user_pass']) ){
                    return back() -> with('msg','用户名或密码不能为空！');
                }
                $map['user_name'] = $input['user_name'];
                $map['user_pass'] = md5(config('app.md5_add_str'). $input['user_pass'] . config('app.md5_add_str'));
                $user = User::where($map) ->orderBy('user_id', 'desc')->first();
                if (empty($user)){
                    return back() -> with('msg','用户名不存在！');
                }

                $session_memary['user_name'] = $input['user_name'];
                $session_memary['user_id'] = $user->user_id;
                $session_memary['login_time'] = date('Y-m-d');
                session(['user_info'=>$session_memary]);
                unset($session_memary);
                return redirect('admin/index');
            }
        }else{
            return view('admin.login');
        }
    }

    //生成验证码
    public function code(){
           $code = new \Code();
           echo  $code->make();
    }

    //退出登录
    public function destory_login(){
        session(['user_info'=>null]);
        return redirect('admin/login');
    }

    //修改密码
    public function password_update(){
        if ($input = input::all()){

            $rules = [
                'user_pass'=>'required|between:6,20|confirmed',
            ];

            $message = [
                'user_pass.required'=>'新密码不能为空！',
                'user_pass.between'=>'新密码必须在6-20位之间！',
                'user_pass.confirmed'=>'新密码和确认密码不一致！',
            ];

            $validator = Validator::make($input,$rules,$message);
            if ($validator->passes()){
                $map = [];
                $map['user_id'] = session('user_info')['user_id'];
                $user = User::where($map) -> first();
                $user -> user_pass = create_password($input['user_pass']);
                $res = $user ->save();

                return redirect('admin/info');



            }else{
              return back()->withErrors($validator);
            }


        }
        return view('admin.pass');
    }


}
