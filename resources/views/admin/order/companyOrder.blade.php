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
                订单列表 <small>本周</small>
            </h1>
        </div>
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <form action="/admin/companyorder/" method="get" class="form-inline">

                                <div class="input-group mb-1 col-lg-3 col-md-4 col-sm-6">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        时间选择
                                      </span>
                                    </div>
                                    <input type="text" name="date"  class="form-control float-right" id="range_date" value="{{$date or ''}}">
                                  </div>
                                </div>
                                <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            选择商家
                                          </span>
                                        </div>
                                        <select name="sid" class="form-control">
                                            <option value="">---选择商家---</option>
                                            @foreach($shop as $s)
                                            <option value="{{$s->sid}}" @if($s->sid == $sid) selected @endif>{{$s->sname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                 <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                    <button type="submit" class="btn btn-info btn-sm">提交</button>&nbsp;
                                    <a href="/admin/order/export/1/1" class="btn btn-info right">导出本周Excel表</a>
                                </div>
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

                                            <td>{{$shops[$o->sid]}}</td>
                                            <td>{{$o->food}}</td>
                                            <td>{{$types[$o->tmark]}}</td>
                                            {{--<td>@if($o->week_of_year-$thisWeek==0)本周@elseif($o->week_of_year-$thisWeek==1)下周@else其他时间@endif</td>--}}
                                            <td>{{$o->total}}</td>
                                                <td>{{$o->date}}</td>
                                                {{--<td><a href="{{url('admin/shop')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit "></i>编辑</a> </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $order->appends(['tmark'=>$tmark,'sid'=>$sid])->links('admin.layouts.pagination') }}
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
