@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div id="page-wrapper" >
        <div class="header">
            <h1 class="page-header">
                食物列表 <small>Responsive tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">主页</a></li>
                <li><a href="#">食物设置</a></li>
                <li class="active">食物列表</li>
            </ol>

        </div>

        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @if(session('foodMsg') == 1)
                                <div class="alert alert-success">
                                    <strong> 操作成功!</strong>
                                </div>
                            @elseif(session('foodMsg') == 2)
                                <div class="alert alert-danger">
                                    <strong>操作失败!</strong>
                                </div>
                            @endif


                                <form action="/admin/food" method="post" class="list-inline">
                                    {{ csrf_field() }}
                                    商家：<select name="sid" id="">
                                        <option value="">---全部---</option>
                                        @foreach($shop as $s)
                                        <option value="{{$s->sid}}" @if($s->sid == $shopId) selected @endif> {{$s->sname}}</option>
                                            @endforeach
                                    </select>
                                    <button class="btn btn-info right">提交</button>
                                    <a href="/admin/food/add" class="btn btn-info right">添加食物</a>
                                </form>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th><label for="selectAll"><input type="checkbox" id="selectAll" class="checkbox-inline"> 序号</label></th>
                                        <th>商家名称</th>
                                        <th>食物名称</th>
                                        <th>食物分类</th>
                                        <th>价格(元)</th>
                                        <th>是否自动勾选</th>
                                        <th>是否启用</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($food as $f)
                                        <tr class="gradeA">


                                                <label for="fid_{{$f->fid}}">
                                                    <td class="selectId">
                                                        <input type="checkbox" value="{{$f->fid}}" class="foodId" id="fid_{{$f->fid}}">{{$f->fid}}
                                                    </td>
                                                </label>

                                            <td>{{$f->sname}}</td>
                                            <td>{{$f->fname}}</td>
                                            <td>@if($f->ftype==1)菜@elseif($f->ftype==2)饭@elseif($f->ftype==3)饮料@else未分类@endif</td>
                                            <td>{{$f->price}}</td>
                                            <td>@if($f->ischecked==1)否@elseif($f->ischecked==2)是@else其他@endif</td>
                                            <td>@if($f->fstate==1)启用@elseif($f->fstate==2)禁用@else其他@endif</td>
                                            <td>
                                                <a href="food/edit/{{$f->fid}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a>
                                                <a href="javascript:;" onclick="delFood({{$f->fid}});" class="btn btn-danger btn-xs"><i class="fa fa-pencil"></i>删除</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
            <!-- /. ROW  -->

        </div>
    </div>
    <!-- /. PAGE INNER  -->
@stop
@section('scripts')
    <script>
        function delFood(fid) {
            if (confirm("确认删除吗?请谨慎操作!")) {
                $.ajax({
                    type: "POST",//方法类型
                    dataType: "json",//预期服务器返回的数据类型
                    url: "/admin/food/delFood/"+fid ,//url
                    data: '',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        // console.log(result);//打印服务端返回的数据(调试用)
                        if (result.menuMsg == 1) {
                            alert("删除成功");
                            location.reload();
                        }else{
                            alert("删除失败");
                            location.reload();
                        }
                    },
                    error : function() {
                        alert("删除失败！");
                    }
                });
            }
        }

        $('.selectId').on('click',function () {
            console.log(11111)
        })
    </script>
    @stop
