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
                订单列表
            </h1>
        </div>

        {{--<div class="container-fluid">--}}

            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <form action="/admin/myorder/" method="get" class="list-inline">
                                    <label for="date1" >
                                        <small><span class="">开始时间：</span><input class="layui-input date-item" type="text" id="date1" name="start" placeholder="yyyy-MM-dd" lay-key="1" value="{{$start or '1'}}"></small>
                                    </label>

                                <label for="date2" >
                                    <small><span class="">结束时间：</span><input class="layui-input date-item" type="text" id="date2" name="end" placeholder="yyyy-MM-dd" lay-key="2" value="{{$end or ''}}"></small>
                                </label>
                                <label>
                                    <small>时间:<select name="tmark" id="">
                                    <option value="">---请选择---</option>
                                    @foreach($type as $t)
                                    <option value="{{$t->tmark}}">{{$t->tname}}</option>
                                    @endforeach
                                </select> </small>
                                </label>
                                <button type="submit" class="btn btn-info right">查询</button>
                                <a href="/admin/order/shopexport/@if($start==0)1 @else{{$start}}@endif/@if($end==0)1 @else{{$end}}@endif" class="btn btn-info right">导出Excel表</a>*先选开始/结束时间查询后,再导出
                            </form>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>用户编号</th>
                                        {{--<th>用户名称</th>--}}
                                        {{--<th>商家</th>--}}
                                        <th>食物</th>
                                        <th>订单类型</th>
                                        <th>价格</th>
                                        <th>下单时间</th>
                                        <th>订单日期</th>
                                        {{--<th>操作</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order as $o)
                                        <tr class="gradeA">
                                            @foreach($user as $u)
                                            @if($u->uid == $o->uid)
                                                    <td>{{$u->uname}}</td>
{{--                                                    <td>{{$u->realname}}</td>--}}
                                                @endif
                                            @endforeach

{{--                                            <td>{{$o->sname}}</td>--}}
                                            <td>{{$o->food}}</td>
                                            <td>{{$o->tname}}</td>
                                            {{--<td>@if($o->week_of_year-$thisWeek==0)本周@elseif($o->week_of_year-$thisWeek==1)下周@else其他时间@endif</td>--}}
                                            <td>{{$o->total}}</td>
                                                <td>{{$o->created_at}}</td>
                                                <td>{{$o->date}}</td>
                                                {{--<td><a href="{{url('admin/shop')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $order->appends(['tmark'=>$tmark,'start'=>$start,'end'=>$end])->links() }}
                            </div>

                        </div>
                    </div>
                    <!--End Advanced Tables -->
                {{--</div>--}}
            {{--</div>--}}
            <!-- /. ROW  -->

        {{--</div>--}}
    </div>
    <!-- /. PAGE INNER  -->
@stop

@section('scripts')
    <script>
        // //日期范围
        // laydate.render({
        //     elem: '#date'
        //     ,range: true
        // });
        //开启公历节日
        laydate.render({
            elem: '#date1'
            ,calendar: true
        });
        //开启公历节日
        laydate.render({
            elem: '#date2'
            ,calendar: true
        });
        //同时绑定多个
        // lay('.date-item').each(function(){
        //     laydate.render({
        //         elem: this
        //         ,trigger: 'click'
        //     });
        // });

    </script>
    @stop