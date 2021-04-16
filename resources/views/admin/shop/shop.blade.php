@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

        <div class="content-wrapper">
            <div class="content-header">
                <h1 class="page-header">
                    商家列表 <a href="/admin/shop/add" class="btn btn-primary btn-xs">添加商家</a>
                </h1>
            </div>
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                    <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                @if(session('shopMsg') == 1)
                                    <div class="alert alert-success">
                                        <strong> 操作成功!</strong>
                                    </div>
                                @elseif(session('shopMsg') == 2)
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
                                            <th>商家名称</th>
                                            <th>供餐</th>
                                            <th>金额限制</th>
                                            <th>联系方式</th>
                                            <th>地址</th>
                                            <th>是否启用</th>
                                            <th>可点餐公司</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($shop as $s)
                                        <tr class="gradeA">
                                            <td>{{$s->sname}}</td>
                                            <td>{{$type[$s->type]}}</td>
                                            <td>{{$s->limit_money}}</td>
                                            <td>{{$s->phone}}</td>
                                            <td>{{$s->address}}</td>
                                            <td>@if($s->state==1)启用@elseif($s->state==2)禁用@else其他@endif</td>
                                            <td>
                                                @if(is_array($s->companys))
                                                @foreach($s->companys as $v)
                                                    {{$companys[$v]}}&nbsp;
                                                @endforeach
                                                @endif

                                            </td>
                                            <td>
                                                <a href="/admin/shop/edit/{{$s->sid}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>
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

