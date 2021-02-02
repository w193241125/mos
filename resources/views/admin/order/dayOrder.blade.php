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
                订单列表 <small>默认显示本周</small>
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
                            <form action="/admin/dayorder" class="form-inline" method="get">
                                <label for="date" >
                                    <small><span class="">开始时间：</span><input class="layui-input" type="text" id="date" name="date" placeholder="yyyy-MM-dd" lay-key="1" value="{{$date or ''}}"></small>
                                </label>
                                <label for="dates" >
                                    <small><span class="">结束时间：</span><input class="layui-input" type="text" id="dates" name="dates" placeholder="yyyy-MM-dd" lay-key="2" value="{{$dates or ''}}"></small>
                                </label>
                                @if(Auth::user()->state == 3)
                                    商家:<select name="sid" id="">
                                    <option value="">---全部---</option>
                                    @foreach($shop as $s)
                                        <option value="{{$s->sid}}" @if($s->sid == $sid) selected @endif>{{$s->sname}}</option>
                                    @endforeach
                                    </select>

                                    公司:<select name="company" id="">
                                        <option value="">---全部---</option>
                                        <option value="1" @if($company==1) selected @endif>350</option>
                                        <option value="2" @if($company==2) selected @endif>旭力</option>
                                        <option value="3" @if($company==3) selected @endif>瑞鲨</option>
                                        <option value="4" @if($company==4) selected @endif>牛越</option>
                                        <option value="5" @if($company==5) selected @endif>XT</option>
                                    </select>
                                @endif
                                <small><button class="btn btn-primary">提交</button></small>
                                {{--<a href="/admin/order/export/{{$start or 1}}/{{$end or 1}}" class="btn btn-info right" data-toggle="tooltip"  title="默认本周,选择时间查询后可导出时间段订单">导出Excel表</a>--}}
                            </form>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>商家</th>
                                        <th>数量</th>
                                        <th>订单时间</th>
                                        <th>价格</th>
                                        {{--<th>操作</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dayOrder as $d)
                                        <tr class="gradeA">
                                            <td>{{$d->sname}}</td>
                                            <td>{{$d->num}}</td>
                                            <td>{{$tdate}}</td>
                                            {{--<td>@if($o->week_of_year-$thisWeek==0)本周@elseif($o->week_of_year-$thisWeek==1)下周@else其他时间@endif</td>--}}
                                            <td>
                                                {{--城市简餐，隆江猪脚饭，木桶饭--}}
                                                @if($d->sid==2)
                                                    {{$d->total + $d->num}}
                                                @else{{$d->total}}@endif
                                            </td>
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
        //常规用法
        laydate.render({
            elem: '#date'
        });
        //国际版
        laydate.render({
            elem: '#dates'
        });
    </script>
@stop