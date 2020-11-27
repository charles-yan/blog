<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    //
    public function login(){
        return view('admin.login');
    }
    //获取验证码

    public function doLogin(Request $request){
        $input = $request -> except('_token');
        $rule=[
            'username'=>'required|between:4,18',
            'password'=>'required|max:255',
//            'captcha'=>'required|captcha'
        ];
        $msg=[
            'username.required'=>'用户名不能为空',
            'username.between'=>'用户名必须是4-18位',
            'password.required'=>'密码不能为空',
            'captcha.required'=>'验证码不能为空',
            'captcha.captcha'=>'验证码错误',
        ];
        //$validator=Validator::make['需要验证的表单数据','校验规则','错误提示']
        $validator = Validator::make($input, $rule,$msg);
        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        };

        //校验用户信息是否存在
        $user=User::where('username',$input['username'])->first();
        if(!$user){
            return redirect('admin/login')->with('errors','用户名为空');
        };
        //验证密码是否正确
        if($input['password'] != Crypt::decrypt($user->password)){
            return redirect('admin/login')->with('errors','密码错误');
        };
        //保存到本地session
        session()->push('user',$user);
        return redirect('admin/index');
    }
    public function index(){
        return view('admin.index');
    }
    public function welcome(){
        return view('admin.welcome');
    }
    public function logout(){
        //清除session中登录信息
        session()->flush();
        return redirect('admin/login');
        //返回首页
    }
}
