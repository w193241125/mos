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
                            <form action="/admin/myorder/" method="get" class="form-inline">
                                <div class="input-group mb-1 col-lg-2 col-md-3 col-sm-6">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        开始时间
                                      </span>
                                    </div>
                                    <input type="text" name="date"  class="form-control float-right" id="date" value="{{$date or ''}}">
                                  </div>
                                </div>

                                <div class="input-group mb-1 col-lg-2 col-md-3 col-sm-6">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        结束时间
                                      </span>
                                    </div>
                                    <input type="text" name="dates"  class="form-control float-right" id="dates" value="{{$dates or ''}}">
                                  </div>
                                </div>

                                <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            时间
                                          </span>
                                        </div>
                                        <select name="tmark" class="form-control">
                                            <option value="">---请选择---</option>
                                            @foreach($type as $t)
                                            <option value="{{$t->tmark}}" @if($t->tmark == $tmark) selected @endif>{{$t->tname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                    <button type="submit" class="btn btn-primary btn-sm">查询</button>&nbsp;
                                    <a href="/admin/order/shopexport/@if($date==0)1 @else{{$date}}@endif/@if($dates==0)1 @else{{$dates}}@endif" class="btn btn-info right">导出Excel表</a>
                                </div>*先选开始/结束时间查询后,再导出
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
                                {{ $order->appends(['tmark'=>$tmark,'date'=>$date,'dates'=>$dates])->links() }}
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