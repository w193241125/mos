@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

        <div id="page-wrapper" >
            <div class="header">
                <h1 class="page-header">
                    用户列表 <small>Responsive tables</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#">主页</a></li>
                    <li><a href="#">用户设置</a></li>
                    <li class="active">用户列表</li>
                </ol>

            </div>
            <div id="page-inner">

                <div class="row">
                    <div class="col-md-12">
                    <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                @if(session('userMsg') == 1)
                                    <div class="alert alert-success">
                                        <strong> 操作成功!</strong>
                                    </div>
                                @elseif(session('userMsg') == 2)
                                    <div class="alert alert-danger">
                                        <strong>操作失败或未执行任何修改!</strong>
                                    </div>
                                 @endif
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th>用户名</th>
                                            <th>真实姓名</th>
                                            {{--<th>联系方式</th>--}}
                                            <th>是否启用</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($user as $u)
                                        <tr class="gradeA">
                                            <td>{{$u->uname}}</td>
                                            <td>{{$u->realname}}</td>
{{--                                            <td>{{$u->phone}}</td>--}}
                                            <td>{{$u->state}}</td>
                                            <td><a href="{{url('admin/user/edit/').'/'.$u->uid}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>
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

