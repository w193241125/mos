@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

        <div id="page-wrapper" >
            <div class="header">
                <h1 class="page-header">
                    菜单列表 <small>Responsive tables</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#">主页</a></li>
                    <li><a href="#">菜单设置</a></li>
                    <li class="active">菜单列表</li>
                </ol>

            </div>
            <div id="page-inner">

                <div class="row">
                    <div class="col-md-12">
                    <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                @if(session('menuMsg') == 1)
                                    <div class="alert alert-success">
                                        <strong> 添加成功!</strong>
                                    </div>
                                @elseif(session('menuMsg') == 2)
                                    <div class="alert alert-danger">
                                        <strong>添加失败!</strong>
                                    </div>
                                 @endif
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th>商家名称</th>
                                            <th>菜单</th>
                                            <th>时间</th>
                                            <th>是否启用</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($menu as $f)
                                        <tr class="gradeA">
                                            <td>{{$f->sname}}</td>
                                            <td>{{$f->fid}}</td>
                                            <td>{{$f->tname}}</td>
                                            <td>{{$f->state}}</td>
                                            <td><a href="{{url('/shop')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>
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

