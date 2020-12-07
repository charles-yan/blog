<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        @include('admin.pubilc.style')
        @include('admin.pubilc.script')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script type="text/javascript" src="{{asset('admin/js/xadmin.js')}}"></script>
    </head>
    <body>
    <div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="">首页</a>
                <a href="">分类管理</a>
                <a>
                    <cite>多级分类</cite></a>
            </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
        </a>
    </div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body ">
                        <form class="layui-form layui-col-space5">
                            <div class="layui-input-inline layui-show-xs-block">
                                <input class="layui-input" placeholder="分类名" name="cate_name"></div>
                            <div class="layui-input-inline layui-show-xs-block">
                                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>搜索</button>
                            </div>
                        </form>
                        <hr>
                        <blockquote class="layui-elem-quote">每个tr 上有两个属性 cate-id='1' 当前分类id fid='0' 父级id ,顶级分类为 0，有子分类的前面加收缩图标<i class="layui-icon x-show" status='true'>&#xe623;</i></blockquote>
                    </div>
                    <div class="layui-card-header">
                        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                        <button class="layui-btn" onclick="xadmin.open('添加分类','/admin/cate/create',600,400)"><i class="layui-icon"></i>添加分类</button>
                    </div>
                    <div class="layui-card-body ">
                        <table class="layui-table layui-form">
                            <thead>
                            <tr>
                                <th width="20">
                                    <input type="checkbox" name="" lay-skin="primary">
                                </th>
                                <th width="70">ID</th>
                                <th>栏目名</th>
                                <th width="50">排序</th>
                                <th width="80">状态</th>
                                <th width="250">操作</th>
                            </thead>
                            <tbody class="x-cate">
                            @foreach($cate as $item)
                            <tr cate-id="{{$item->cate_id}}" fid="{{$item->cate_pid}}" >
                                <td id="{{$item->cate_id}}">
                                    <input type="checkbox" name="" lay-skin="primary">
                                </td>
                                <td>{{$item->cate_id}}</td>
                                <td>
                                    @if($item->cate_pid==0)
                                    <i class="layui-icon x-show" status='true'>&#xe623;</i>
                                    @endif
                                    {{$item->cate_name}}
                                </td>
                                <td><input type="text" class="layui-input x-sort" name="cate_order" onchange="changeOrder(this,{{$item->cate_id}})" value="{{$item->cate_order}}"></td>
                                <td>
                                    @if($item->status==1)
                                        <input type="checkbox" checked name="switch" onchange="changeSwitch(this,{{$item->cate_id}})" lay-text="开启|停用" lay-filter="check" lay-skin="switch">
                                    @else
                                        <input type="checkbox" name="switch" onchange="changeSwitch(this,{{$item->cate_id}})"  lay-text="开启|停用" lay-filter="check" lay-skin="switch">
                                    @endif
                                </td>
                                <td class="td-manage">
                                    <button class="layui-btn layui-btn layui-btn-xs"  onclick="xadmin.open('编辑','/admin/cate/{{$item->cate_id}}/edit',600,400)"><i class="layui-icon">&#xe642;</i>编辑</button>
                                    @if($item->cate_pid>0)
                                        <button class="layui-btn layui-btn-disabled layui-btn-xs" disabled  onclick="xadmin.open('添加子栏目','/admin/cate/addchild/{{$item->cate_id}}/edit',600,400)"><i class="layui-icon">&#xe642;</i>添加子栏目</button>
                                    @else
                                        <button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="xadmin.open('添加子栏目','/admin/cate/addchild/{{$item->cate_id}}/edit',600,400)"><i class="layui-icon">&#xe642;</i>添加子栏目</button>
                                    @endif
                                    <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="cate_del(this,'{{$item->cate_id}}')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
                                </td>
                            </tr>
                             @endforeach
                            </tbody>
                        </table>
                    </div>
{{--                    <div class="layui-card-body">--}}
{{--                        <div class="page">--}}
{{--                            <div>--}}
{{--                                @if($cate->onFirstPage())--}}
{{--                                    <a class="prev-dark" href="javascript:;">&lt;&lt;</a>--}}
{{--                                @else--}}
{{--                                    <a class="prev-active" href="{{$cate->previousPageUrl()}}">&lt;&lt;</a>--}}
{{--                                @endif--}}
{{--                                <span  class="current">{{$cate->currentPage()}}</span>--}}
{{--                                @if($cate->hasMorePages())--}}
{{--                                    <a class="move-active" href="{{$cate->nextPageUrl()}}">&gt;&gt;</a>--}}
{{--                                @else--}}
{{--                                    <a class="move-dark" href="javascript:;">&gt;&gt;</a>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    <script>
        let _status=0
        layui.use(['form'], function(){
            form = layui.form;
            form.on('switch(check)', function(data){
                console.log(data.elem); //得到checkbox原始DOM对象
                console.log(data.elem.checked); //开关是否开启，true或者false
                console.log(data.value); //开关value值，也可以通过data.elem.value得到
                console.log(data.othis); //得到美化后的DOM对象
                _status=data.elem.checked?1:0;
            });
        });
        function changeSwitch(obj,id){
            console.log(id,11111);
            return ;
            $.ajax({
                type:"PUT",
                url:"/admin/cate/"+id,
                data:{
                    '_token':'{{csrf_token()}}',
                    'status':_status
                },
                success:function (res) {
                    if(res.status=='success'){
                        layer.msg(res.message,{icon:6},function () {
                            location.reload()
                        });
                    }else{
                        layer.msg(res.message,{icon:5});
                    }
                }
            })
        }
        function changeOrder(obj,id) {
            var order=$(obj).val();
            $.ajax({
                type:'POST',
                url:'/admin/cate/changeorder',
                data:{
                    '_token':'{{csrf_token()}}',
                    'cate_id':id,
                    'cate_order':order
                },
                success:function (res) {
                    if(res.status=='success'){
                        layer.msg(res.message,{icon:6},function () {
                            location.reload()
                        });
                    }else{
                        layer.msg(res.message,{icon:5});
                    }
                }
            })
        }

        /*用户-删除*/
        function cate_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                $(obj).parents("tr").remove();
                layer.msg('已删除!',{icon:1,time:1000});
            });
        }

        // 分类展开收起的分类的逻辑
        $(function(){
            $("tbody.x-cate tr[fid!='0']").hide();
            // 栏目多级显示效果
            $('.x-show').click(function () {
                if($(this).attr('status')=='true'){
                    $(this).html('&#xe625;');
                    $(this).attr('status','false');
                    cateId = $(this).parents('tr').attr('cate-id');
                    $("tbody tr[fid="+cateId+"]").show();
                }else{
                    cateIds = [];
                    $(this).html('&#xe623;');
                    $(this).attr('status','true');
                    cateId = $(this).parents('tr').attr('cate-id');
                    getCateId(cateId);
                    for (var i in cateIds) {
                        $("tbody tr[cate-id="+cateIds[i]+"]").hide().find('.x-show').html('&#xe623;').attr('status','true');
                    }
                }
            })
        })

        var cateIds = [];
        function getCateId(cateId) {
            $("tbody tr[fid="+cateId+"]").each(function(index, el) {
                id = $(el).attr('cate-id');
                cateIds.push(id);
                getCateId(id);
            });
        }

    </script>
    </body>
</html>
