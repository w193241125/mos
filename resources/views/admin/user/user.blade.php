@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

        <div class="content-wrapper">
            <div class="content-header">
                <h1 class="page-header">
                    用户列表&nbsp;&nbsp;<a href="/admin/user/add" class="btn btn-primary btn-xs">添加用户</a>
                </h1>
            </div>
            <div class="container-fluid">

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

                                        <div class="input-group mb-1 col-lg-2 col-md-3 col-sm-6">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                账号
                                              </span>
                                            </div>
                                            <input type="text" id="uname" name="uname" class="form-control" placeholder="请输入用户名"  value="{{$uname}}">
                                          </div>
                                        </div>
                                        <div class="input-group mb-1 col-lg-2 col-md-3 col-sm-6">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                姓名
                                              </span>
                                            </div>
                                            <input type="text" id="realname" name="realname" class="form-control" placeholder="请输入姓名"  value="{{$realname}}">
                                          </div>
                                        </div>
                                    <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                用户状态
                                              </span>
                                            </div>
                                            <select name="state" class="form-control">
                                                <option value="">---全部---</option>
                                            <option value="1" @if($state==1) selected @endif>启用</option>
                                            <option value="2" @if($state==2) selected @endif>禁用</option>
                                            <option value="3" @if($state==3) selected @endif>管理员</option>
                                            <option value="4" @if($state==4) selected @endif>商家</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                选择公司
                                              </span>
                                            </div>
                                            <select name="company" class="form-control">
                                                <option value="">---选择公司---</option>
                                                 @foreach($companys as $c)
                                                <option value="{{$c->id}}" @if($company==$c->id) selected @endif>{{$c->company_name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                        <button class="btn btn-primary">提交</button>&nbsp;
                                    </div>

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
                                            <td>@if($u->company ==1) 三五零 @elseif($u->company ==2) 旭力 @elseif($u->company ==3) 瑞鲨 @elseif($u->company ==4) 牛越@elseif($u->company ==5) XT @endif</td>
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

