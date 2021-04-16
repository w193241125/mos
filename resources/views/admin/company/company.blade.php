@extends('admin.layouts.app')

@section('title')
    公司列表
@stop

@section('content')

        <div class="content-wrapper">
            <div class="content-header">
                <h1 class="page-header">
                    公司列表 <a href="/admin/company/add" class="btn btn-primary btn-xs">添加公司</a>
                </h1>
            </div>
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                    <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                @if(session('companyMsg') == 1)
                                    <div class="alert alert-success">
                                        <strong> 操作成功!</strong>
                                    </div>
                                @elseif(session('companyMsg') == 2)
                                    <div class="alert alert-danger">
                                        <strong>操作失败!</strong>
                                    </div>
                                 @endif

                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>公司名称</th>
                                            <th>代号</th>
                                            <th>是否启用</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($company as $s)
                                        <tr class="gradeA">
                                            <td>{{$s->id}}</td>
                                            <td>{{$s->company_name}}</td>
                                            <td>{{$s->code_name}}</td>
                                            <td>@if($s->state==1)启用@elseif($s->state==2)禁用@else其他@endif</td>
                                            <td>
                                                <a href="/admin/company/edit/{{$s->id}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>
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

