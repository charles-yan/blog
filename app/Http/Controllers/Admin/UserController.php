<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *  列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=User::get();
        return view('admin.user.list',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     * 创建前加载的数据
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return  view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     * 执行添加操作
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //获取参数
        $input=$request->except('_token');
        $username=$input['username'];
        $password=Crypt::encrypt($input['repass']);
        $isActive=$input['is_active'];
        $res=User::create(['username'=>$username,'password'=>$password,'is_active'=>$isActive,'email'=>$input['email']]);
        if($res){
            $data=[
                'status'=>'success',
                'message'=>'添加成功'
            ];
        }else{
            $data=[
                'status'=>'fail',
                'message'=>'添加失败'
            ];
        };
        return $data;
    }

    /**
     * Display the specified resource.
     * 单个明细行信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    //        return  view('admin.user.list');
    }

    /**
     * Show the form for editing the specified resource.
     * 修改
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //修改用户信息
        $user = User::find($id);
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * 更新
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //根据ID查找需要修改的记录
        $user=User::find($id);
        //获取需要修改的用户名
        $username=$request->input('username');
        $password=$request->input('pass');
        if($password){
            $reg= "/^[_0-9a-z]{6,16}$/i";
            if(!preg_match($reg,$password)){
                return $data=[
                    'status'=>'fail',
                    'message'=>'密码不能少于6位'
                ];
            };
            $password=Crypt::encrypt($password);
            $user->password=$password;
        };
        if($request->input('is_active')){
            $user->is_active=$request->input('is_active');
        };
        if($username){
            $user->username=$username;
        };
        $res=$user->save();
        //如果当前用户修改了密码成功则退出重新登录,这步怎么实现?

        if($res){
            $data=[
                'status'=>'success',
                'message'=>'修改成功'
            ];
        }else{
            $data=[
                'status'=>'fail',
                'message'=>'修改失败'
            ];
        };
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *  删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //根据ID查找需要修改的行数据
        $arr=explode(',',$id);
        $res =User::destroy($arr);
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
