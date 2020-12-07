<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    //
    public $table='categroy';
    public $primaryKey='cate_id';

    /**
     * 不可批量赋值的属性 表示所有的参数都可操作
     * @var array
     */
    protected $guarded = [];

    public $timestamps=false;

    //格式化分类
    public function tree(){
        //先获取数据并排序下
        $cate=$this->orderBy('cate_order','asc')->get();
       return $this->getTree($cate);
    }
    public function getTree($category){
        //格式化分类
        //先找到一级分类
        $arr=[];
        foreach ($category as $k=>$v){
            if($v->cate_pid==0){
                $arr[]=$v;
//                获取一级下的二级分类
                foreach ($category as $m=>$n){
                    if($v->cate_id==$n->cate_pid){
                        $n->cate_name='  |--- '.$n->cate_name;
                        $arr[]=$n;
                    }
                }
            }
        };
        return $arr;
    }

}
