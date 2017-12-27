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
                        <div class="panel-heading">
                            添加用户
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form action="/admin/user/doadd" method="post">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="sub-title">用户名</div>
                                        <div>
                                            <input type="text" name="uname" class="form-control" placeholder="请输入用户名" required>
                                        </div>
                                        <div class="sub-title">真实姓名</div>
                                        <div>
                                            <input type="text" name="realname" class="form-control" placeholder="请输入真实姓名" required>
                                        </div>
                                        <div class="sub-title">密码</div>
                                        <div>
                                            <input type="text" name="password" class="form-control" placeholder="不填则默认为123456" >
                                        </div>

                                        <div class="sub-title">是否启用</div>
                                        <div>
                                            <input type="radio" name="state" class="radio3" value="1" checked>启用
                                            <input type="radio" name="state" class="radio3" value="2">禁用
                                        </div>

                                        <div class="sub-title"></div>
                                        <button type="submit" class="btn btn-default">确认添加</button>
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

