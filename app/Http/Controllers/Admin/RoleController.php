<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permission;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role=Role::paginate(10);
        return  view('admin.role.list',compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取所有权限列表;
        $perms=Permission::paginate(10);
//        $own_perms=Role::with(['rolePermission' => function($query){
//            $query->with(['permission']);
//        }])->find(1);
//        dd($own_perms->toArray());
        return  view('admin.role.add',compact('perms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //获取表单发来的数据
        $input=$request->except('_token');
        //验证表单 角色名不能为空
        $name=$request->input('name');
        $data=[];
        if(Role::where('name',$name)->first()){
            $data=[
                'status'=>'fail',
                'message'=>'该角色名已存在！'
            ];
        }else{
            $res= Role::create($input);
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
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //修改用户信息
        $role= Role::find($id);
        //获取所有权限列表;
        $perms=Permission::paginate(10);
        //获取选中的权限ID
        $own_perms=Role::with(['permission'])->find($id);
        $own_arr=array();
        if(count($own_perms->permission)>0){
            $arr=$own_perms->permission->toArray();
            $a=array_column($arr,null,'id');
            $own_arr=array_keys($a);
        };
        return view('admin.role.edit',compact('role','perms','own_arr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $role=Role::find($id);
        $status=$request->input('status');
        $name=$request->input('name');
        $premssion_id=$request->input('premssion_id');
        $desc=$request->input('desc');
        if($name){
            $role->name=$name;
        };
        if($desc){
            $role->desc=$desc;
        }

        if(count($premssion_id)>0){
            //删除原表数据关联的权限ID
                \DB::table('role_permission')->where('role_id',$id)->delete();
            //添加新数据
            foreach ($premssion_id as $v){
                \DB::table('role_permission')->insert(['role_id'=>$id,'permission_id'=>$v]);
            }
        };
        $role->status=$status;
        $res=$role->save();
        if($res){
            $data=[
                'status'=>'success',
                'message'=>'更新成功'
            ];
        }else{
            $data=[
                'status'=>'success',
                'message'=>'更新成功'
            ];
        };
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $arr=explode(',',$id);
        $res=Role::destroy($arr);
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
