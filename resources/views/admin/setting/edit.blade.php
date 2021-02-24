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
                <li class="active">修改商家信息</li>
            </ol>

        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <a href="javascript:history.go(-1);" class="btn btn-primary btn-toolbar ">返回</a>
                            <div class="table-responsive">
                                <form action="/admin/setting/timelimiteddoedit" method="post">
                                    <input type="hidden" name="id" value="{{$timeLimited->id}}">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="sub-title">时间</div>
                                        <div>
                                            <select name="time_mark" id="">
                                                <option value="1" {{$timeLimited->time_mark==1?'selected':''}}>早上</option>
                                                <option value="2" {{$timeLimited->time_mark==2?'selected':''}}>中午</option>
                                                <option value="3" {{$timeLimited->time_mark==3?'selected':''}}>晚上</option>
                                            </select>
                                        </div>
                                        <div class="sub-title">限制时间</div>
                                        <div>
                                            <input type="time" name="time_limited" class="form-control" value="{{$timeLimited->time_limited}}" >
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

