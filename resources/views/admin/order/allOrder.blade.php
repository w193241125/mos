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
                            <form action="/admin/allOrder" class="form-inline">
                                <label for="test6" >
                                    <small><span class="">范围选择：</span><input class="layui-input" type="text" id="date" name="date" placeholder="yyyy-MM-dd" lay-key="1" value="{{$date or ''}}"></small>
                                </label>
                                商家:<select name="sid" id="">
                                    <option value="">---全部---</option>
                                    @foreach($shop as $s)
                                        <option value="{{$s->sid}}">{{$s->sname}}</option>
                                    @endforeach
                                </select>
                                用户名：<label for="uname">
                                    <input type="number" name="uname" placeholder="请输入用户编号" class="small" min="1" value="{{$uname or NULL}}">
                                </label>
                                姓名：<label for="name">
                                    <input type="text" name="name" placeholder="请输入姓名" class="small" min="1" value="{{$name or NULL}}">
                                </label>
                                <small><button class="btn btn-primary">提交</button></small>
                                <a href="/admin/order/export/{{$start or 1}}/{{$end or 1}}" class="btn btn-info right" data-toggle="tooltip"  title="默认本周,选择时间查询后可导出时间段订单">导出Excel表</a>
                            </form>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>编号</th>
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
                                                <td>{{$o->date}}</td>
                                                {{--<td><a href="{{url('admin/shop')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $order->appends(['date'=>$date,'sid'=>$sid,'uname'=>$uanme,'name'=>$name])->links() }}
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