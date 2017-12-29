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
                            <a href="/admin/food/add" class="btn btn-primary">添加食物</a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>商家名称</th>
                                        <th>食物名称</th>
                                        <th>价格(元)</th>
                                        <th>是否启用</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($food as $f)
                                        <tr class="gradeA">
                                            <td>{{$f->fid}}</td>
                                            <td>{{$f->sname}}</td>
                                            <td>{{$f->fname}}</td>
                                            <td>{{$f->price}}</td>
                                            <td>@if($f->state==1)启用@elseif($f->state==2)禁用@else其他@endif</td>
                                            <td><a href="food/edit/{{$f->fid}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>
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