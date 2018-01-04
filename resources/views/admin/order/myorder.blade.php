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
                订单列表 <small>本周</small>
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
                            <form action="/admin/myorder/" method="get" class="list-inline">
                                时间:<select name="tmark" id="">
                                    <option value="">---请选择---</option>
                                    @foreach($type as $t)
                                    <option value="{{$t->tmark}}">{{$t->tname}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-info right">查询</button>
                                <a href="/admin/order/shopexport/1/1" class="btn btn-info right">导出本周Excel表</a>
                            </form>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>用户编号</th>
                                        <th>用户名称</th>
                                        <th>商家</th>
                                        <th>食物</th>
                                        <th>订单类型</th>
                                        <th>价格</th>
                                        <th>订单时间</th>
                                        {{--<th>操作</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order as $o)
                                        <tr class="gradeA">
                                            @foreach($user as $u)
                                            @if($u->uid == $o->uid)
                                                    <td>{{$u->uname}}</td>
                                                    <td>{{$u->realname}}</td>
                                                @endif
                                            @endforeach

                                            <td>{{$o->sname}}</td>
                                            <td>{{$o->food}}</td>
                                            <td>{{$o->tname}}</td>
                                            {{--<td>@if($o->week_of_year-$thisWeek==0)本周@elseif($o->week_of_year-$thisWeek==1)下周@else其他时间@endif</td>--}}
                                            <td>{{$o->total}}</td>
                                                <td>{{$o->created_at}}</td>
                                                {{--<td><a href="{{url('admin/shop')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $order->appends(['tmark'=>$tmark])->links() }}
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