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
                <li class="active">添加用户</li>
            </ol>

        </div>

        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a href="javascript:history.go(-1);" class="btn btn-primary btn-toolbar ">返回</a>
                            <div class="table-responsive">
                                <form action="/admin/user/doedit" method="post">
                                    <input type="hidden" name="uid" value="{{$user->uid}}">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="sub-title">所属公司</div>
                                        <div>
                                            <select name="company" id="" style="width: 160px">
                                                <option value="0" >--请选择--</option>
                                                <option value="1" @if($user->company==1) selected @endif>三五零</option>
                                                <option value="2" @if($user->company==2) selected @endif>旭力</option>
                                                <option value="3" @if($user->company==3) selected @endif>瑞鲨</option>
                                                <option value="4" @if($user->company==4) selected @endif>牛越</option>
                                                <option value="4" @if($user->company==5) selected @endif>XT</option>
                                            </select>
                                        </div>
                                        <div class="sub-title">用户名</div>
                                        <div>
                                            <input type="text" name="uname" class="form-control" placeholder="请输入用户名" value="{{$user->uname}}"  required>
                                        </div>
                                        <div class="sub-title">真实姓名</div>
                                        <div>
                                            <input type="text" name="realname" class="form-control" placeholder="请输入真实姓名" value="{{$user->realname}}" required>
                                        </div>
                                        <div class="sub-title">密码</div>
                                        <div>
                                            <input type="text" name="password" class="form-control" placeholder="不修改则留空" >
                                        </div>

                                        <div class="sub-title">是否启用</div>
                                        <div>
                                            <input type="radio" name="state" class="radio3" value="1" {{$user->state==1?'checked':''}} >启用
                                            <input type="radio" name="state" class="radio3" value="2" {{$user->state==2?'checked':''}} >禁用
                                            <input type="radio" name="state" class="radio3" value="3" {{$user->state==3?'checked':''}} >管理员
                                            <input type="radio" name="state" class="radio3" value="4" {{$user->state==4?'checked':''}} >商家
                                        </div>

                                        <div class="sub-title"></div>
                                        <button type="submit" class="btn btn-default">确认修改</button>
                                    </div>
                                </form>
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

