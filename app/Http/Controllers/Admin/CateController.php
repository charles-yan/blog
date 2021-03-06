<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
    public function changeOrder(Request $request){
        //
        $input=$request->except('_token');
        //通过ID找到分类数据
        $cate=Cate::find($input['cate_id']);
        //修改当前分类的排序值
        $res=$cate->update(['cate_order'=>$input['cate_order']]);
        if($res){
            $data=[
                'status'=>'success',
                'message'=>'保存成功'
            ];
        }else{
            $data=[
                'status'=>'fail',
                'message'=>'保存失败'
            ];
        };
        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $cate=Cate::paginate(10);
        $cate=(new Cate())->tree();
        //处理分类数据
        return view('admin.cate.list',compact('cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取一级分类
        $cate=Cate::where('cate_pid',0)->get();
        return view('admin.cate.add',compact('cate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //获取表单数据
        $input=$request->except('_token');
        $res=Cate::create($input);
        if($res){
            $data=[
                'status'=>'success',
                'message'=>'保存成功'
            ];
        }else{
            $data=[
                'status'=>'fail',
                'message'=>'保存失败'
            ];
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate=Cate::find($id);
        $parent=$cate->toArray();
        $cateId=$cate->cate_pid;
        if($parent['cate_pid']==0){
            $parent['cate_name']='父类';
            $parent['cate_pid']=0;
        }else{
            $parent=Cate::where('cate_pid',0)->get();
        };
        return view('admin.cate.edit',compact('cate','parent','cateId'));
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
        $input=$request->except('_token');
        $cate=Cate::find($id);
        $res=$cate->update($input);
        if($res){
            $data=[
                "status"=>"success",
                "message"=>"更新成功"
            ];
        }else{
            $data=[
                "status"=>"fail",
                "message"=>"更新失败"
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
    }


}
