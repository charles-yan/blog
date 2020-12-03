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
}
