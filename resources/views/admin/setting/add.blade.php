@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="page-header">
                商家列表 <small>Responsive tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">主页</a></li>
                <li><a href="#">商家设置</a></li>
                <li class="active">添加商家</li>
            </ol>

        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            添加商家
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form action="/admin/setting/timelimiteddoadd" method="post">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="sub-title">时间</div>
                                        <div>
                                            <select name="time_mark" id="">
                                                <option value="1">早上</option>
                                                <option value="2">中午</option>
                                                <option value="3">晚上</option>
                                            </select>
                                        </div>
                                        <div class="sub-title">限制时间</div>
                                        <div>
                                            <input type="time" name="time_limited" class="form-control" value="" >
                                        </div>
                                        <div class="sub-title"></div>

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

