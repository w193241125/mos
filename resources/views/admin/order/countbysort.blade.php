@extends('admin.layouts.app')

@section('title')
    商家列表
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('laydate/theme/default/laydate.css')}}">
@stop
@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="page-header">
                订单列表 <small>默认显示今明两天早上</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">主页</a></li>
                <li><a href="#">订单设置</a></li>
                <li class="active">订单列表</li>
            </ol>

        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
{{-- --------------------------------------今日餐--------------------------------------------}}
                        @if(Auth::user()->state==4)
                        @foreach($food_count_today as $mark=>$marks)
                        <div class="panel-body">
                            <h1 class="page-header">{{$week_name[$mark]}}:</h1>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>食物</th>
                                        <th>数量</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($marks as $k=>$d)
                                        <tr class="gradeA">
                                            <td>{{$k}}</td>
                                            <td>{{$d}}</td>
                                        </tr>
                                    @endforeach
                                    {{--<td><a href="{{url('admin/shop')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>--}}
                                    </tbody>
                                </table>
                            </div>
                            @endforeach
                        @endif

                        @if(Auth::user()->state==3)
                            <h1 class="page-header">今日:</h1>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>食物</th>
                                        <th>数量</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($food_count_today as $k7=>$d7)
                                        <tr class="gradeA">
                                            <td>{{$k7}}</td>
                                            <td>{{$d7}}</td>
                                        </tr>
                                    @endforeach
                                    {{--<td><a href="{{url('admin/shop')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>--}}
                                    </tbody>
                                </table>
                                {{--{{ $order->appends(['date'=>$date,'sid'=>$sid,])->links() }}--}}
                            </div>
                                <h1 class="page-header">今日:</h1>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th>食物</th>
                                            <th>数量</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($food_count_today7 as $k7=>$d7)
                                            <tr class="gradeA">
                                                <td>{{$k7}}</td>
                                                <td>{{$d7}}</td>
                                            </tr>
                                        @endforeach
                                        {{--<td><a href="{{url('admin/shop')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>--}}
                                        </tbody>
                                    </table>
                                    {{--{{ $order->appends(['date'=>$date,'sid'=>$sid,])->links() }}--}}
                                </div>
                        @endif

                        @if(Auth::user()->state==4)
                            @foreach($food_count_next as $mark=>$marks)
                            <h1 class="page-header">{{$week_name[$mark]}}:</h1>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>食物</th>
                                        <th>数量</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($marks as $key=>$dd)
                                        <tr class="gradeA">
                                            <td>{{$key}}</td>
                                            <td>{{$dd}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endforeach
                            @endif
                        @if(Auth::user()->state==3)
                            <h1 class="page-header">明日:</h1>
                            <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th>食物</th>
                                            <th>数量</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($food_count_next as $key7=>$dd7)
                                            <tr class="gradeA">
                                                <td>{{$key7}}</td>
                                                <td>{{$dd7}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <h1 class="page-header">明日:</h1>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th>食物</th>
                                            <th>数量</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($food_count_next7 as $key7=>$dd7)
                                            <tr class="gradeA">
                                                <td>{{$key7}}</td>
                                                <td>{{$dd7}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--End Advanced Tables -->

                </div>
            </div>
        </div>
            <!-- /. ROW  -->
    </div>
    <!-- /. PAGE INNER  -->
@stop

@section('scripts')
    <script>
        //日期范围
        laydate.render({
            elem: '#date'
            ,range: true
        });

    </script>
@stop
