<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perms=Permission::paginate(10);
        return  view('admin.permission.list',compact('perms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('admin.permission.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input=$request->except('_token');
        $title=$input['title'];
        $urls=$input['urls'];
        $data=[];
        if(Permission::where('urls',$urls)->first()){
            $data=[
                'status'=>'fail',
                'message'=>'该权限已存在！'
            ];
        }else{
            $res=Permission::create($input);
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
        };
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
        //
        $prems=Permission::find($id);
        return view('admin.permission.edit',compact('prems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $prems=Permission::find($id);
        $status=$request->input('status');
        $title=$request->input('title');
        $urls=$request->input('urls');
        $prems->urls=$urls;
        $prems->title=$title;
        $prems->status=$status;
        $res=$prems->save();
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
        //
        $arr=explode(',',$id);
        $res=Permission::destroy($arr);
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
