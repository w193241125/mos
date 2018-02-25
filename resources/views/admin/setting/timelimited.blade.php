@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div id="page-wrapper" >
        <div class="header">
            <h1 class="page-header">
                商家列表 <small>Responsive tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">主页</a></li>
                <li><a href="#">商家设置</a></li>
                <li class="active">商家列表</li>
            </ol>

        </div>
        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        @if(session('timeLimitedMsg') == 1)
                            <div class="alert alert-success">
                                <strong> 操作成功!</strong>
                            </div>
                        @elseif(session('timeLimitedMsg') == 2)
                            <div class="alert alert-danger">
                                <strong>操作失败!</strong>
                            </div>
                        @endif
                            <a href="/admin/setting/timelimitedadd" class="btn btn-primary">添加</a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>时间</th>
                                        <th>截止时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($timeLimited as $tl)
                                        <tr class="gradeA">
                                            <td>@if($tl->time_mark==1)早上@elseif($tl->time_mark==2)中午@elseif($tl->time_mark==3)晚上@endif</td>
                                            <td>{{$tl->time_limited}}</td>
                                            <td>
                                                <a href="/admin/setting/timelimitededit/{{$tl->id}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a>
                                                <a href="javascript:void();" onclick="confirnDel({{$tl->id}});" class="btn btn-danger btn-xs"><i class="fa fa-pencil "></i>删除</a>
                                            </td>
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
@section('scripts')
    <script>
        function confirnDel(id) {
            var choice = confirm("你确认提交吗?提交后将不可更改。");//确认框。
            if (choice == true) {
                $.ajax({
                    type: "get",
                    url: "/admin/setting/timelimiteddel/" + id,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }, success: function (data) {
                        location.href = "/admin/setting/timelimited";
                    }
                });
            }
        }
    </script>
    @stop

