<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use function Sodium\compare;

class UserController extends Controller
{
    //获取一个页面
    public function add(){
        return view('user.add');
    }
    /*
     * 执行用户添加操作
     * @param 用户提交参数
     * @return 添加是否成功
    */
    public function store(Request $request){
        //获取用户端提交的数据
        $input = $request -> except('_token');
        $input['password']=md5($input['password']);
        //表单验证
        //添加操作 可创建模型来操作 php artisan make:model User
        //引入User模型添加字段
        $res = User::create($input);
        if($res){
            return redirect('user/index');
        }else{
            return back();
        }
    }
    //显示列表
    public function index(){
        //获取用户信息
        $user = User::get();
        //返回用户列表信息 三种方式
        //return view('user.list',['user'=>$user]);
        //return view('user.list')->with('user',$user);
        return view('user.list',compact('user'));
    }
    //修改
    public function edit($id){
        //修改用户信息
        $user = User::find($id);
        return view('user.edit',compact('user'));
    }
    //更新
    public function update(Request $requery){
        $input = $requery->all();
        $user=User::find($input['id']);
        //替换原数据
        $res=$user->update(['username'=>$input['username']]);
        //是否修改成功，跳转到对应页面
        if($res){
            return redirect('user/index');
        }else{
            back();
        }
    }
    //删除
    public function destroy($id){
        $user = User::find($id);
        $res = $user->delete();
        if($res){
            $data=[
                'status'=>'success',
                'message'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>'fail',
                'message'=>'删除失败'
            ];
        };
        return $data;
    }
}
