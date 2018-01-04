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
                                    <form action="/admin/menu" method="get">
                                        <a href="/admin/menu/add" class="btn btn-primary">添加菜单</a>&nbsp;&nbsp;&nbsp;
                                        按周查询：<select name="mweek">
                                            <option value="">--选择时间--</option>
                                            <option value="1">本周</option>
                                            <option value="2">下周</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary">提交</button>
                                    </form>
                            </div>
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th style="width: 100px">商家名称</th>
                                            <th>菜单</th>
                                            <th style="width: 100px">时间</th>
                                            <th style="width: 80px">本周/下周</th>
                                            <th style="width: 80px">是否启用</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($menu as $m)
                                        <tr class="gradeA">
                                            <td>{{$m->sname}}</td>
                                            <td>{{$m->list}}</td>
                                            <td>{{$m->tname}}</td>
                                            <td>@if($m->mweek==1)本周@elseif($m->mweek==2)下周@endif</td>
                                            <td>@if($m->mstate==1)启用@elseif($m->mstate==2)禁用@endif</td>
                                            <td><a href="menu/edit/{{$m->mid}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>
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
