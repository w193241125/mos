@extends('admin.layouts.app')

@section('title')
    商家列表
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('laydate/theme/default/laydate.css')}}">
@stop
@section('content')

    <div id="page-wrapper" >
        <div class="header">
            <h1 class="page-header">
                订单列表 <small>默认显示今明两天早上</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">主页</a></li>
                <li><a href="#">订单设置</a></li>
                <li class="active">订单列表</li>
            </ol>

        </div>

        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{--<form action="/admin/dayorder" class="form-inline" method="get">--}}
                                {{--<label for="test6" >--}}
                                    {{--<small><span class="">范围选择：</span><input class="layui-input" type="text" id="date" name="date" placeholder="yyyy-MM-dd" lay-key="1" value="{{$date or ''}}"></small>--}}
                                {{--</label>--}}
                                {{--@if(Auth::user()->state == 3)商家:<select name="sid" id="">--}}
                                    {{--<option value="">---全部---</option>--}}
                                    {{--@foreach($shop as $s)--}}
                                        {{--<option value="{{$s->sid}}">{{$s->sname}}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>@endif--}}
                                {{--<small><button class="btn btn-primary">提交</button></small>--}}
                                {{--<a href="/admin/order/export/{{$start or 1}}/{{$end or 1}}" class="btn btn-info right" data-toggle="tooltip"  title="默认本周,选择时间查询后可导出时间段订单">导出Excel表</a>--}}
                            {{--</form>--}}
                        </div>

                        <div class="panel-body">
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
                                    @foreach($food_count_today as $k=>$d)
                                        <tr class="gradeA">
                                            <td>{{$k}}</td>
                                            <td>{{$d}}</td>
                                        </tr>
                                    @endforeach
                                    {{--<td><a href="{{url('admin/shop')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>--}}
                                    </tbody>
                                </table>
                                {{--{{ $order->appends(['date'=>$date,'sid'=>$sid,])->links() }}--}}
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
                                    @foreach($food_count_next as $key=>$dd)
                                        <tr class="gradeA">
                                            <td>{{$key}}</td>
                                            <td>{{$dd}}</td>
                                        </tr>
                                    @endforeach
                                    {{--<td><a href="{{url('admin/shop')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>--}}
                                    </tbody>
                                </table>
                                {{--{{ $order->appends(['date'=>$date,'sid'=>$sid,])->links() }}--}}
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
        //日期范围
        laydate.render({
            elem: '#date'
            ,range: true
        });

    </script>
@stop