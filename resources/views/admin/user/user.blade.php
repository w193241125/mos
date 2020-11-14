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
                                @if(session('userMsg'))
                                    <div class="alert alert-success">
                                        <strong> {{session('userMsg')}}!</strong>
                                    </div>
                                @elseif(session('userMsgErr'))
                                    <div class="alert alert-danger">
                                        <strong>{{session('userMsgErr')}}!</strong>
                                    </div>
                                 @endif
                                    <form action="/admin/user" class="form-inline" method="post">
                                        {{csrf_field()}}
                                        用户状态:<select name="state" id="">
                                            <option value="">---全部---</option>
                                            <option value="1">启用</option>
                                            <option value="2">禁用</option>
                                            <option value="3">管理员</option>
                                            <option value="4">商家</option>
                                        </select>
                                        <small><button class="btn btn-primary">提交</button></small>
                                        <a href="/admin/user/add" class="btn btn-primary">添加用户</a>
                                    </form>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th>用户名</th>
                                            <th>真实姓名</th>
                                            <th>所属公司</th>
                                            <th>是否启用</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($user as $u)
                                        <tr class="gradeA">
                                            <td>{{$u->uname}}</td>
                                            <td>{{$u->realname}}</td>
                                            <td>@if($u->company ==1) 三五零 @elseif($u->company ==2) 旭力 @elseif($u->company ==3) 瑞鲨 @elseif($u->company ==4) 牛越@elseif($u->company ==5) XT@endif</td>
                                            <td>@if($u->state==1)启用@elseif($u->state==2)禁用@elseif($u->state==3)管理员@elseif($u->state==4)商家@endif</td>
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

