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
                订单列表 <small>默认显示本周</small>
            </h1>
        </div>


         <section class="content">
         <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <!-- Advanced Tables -->
                    <div class="panel panel-default">

<form action="/admin/dayorder" class="form-inline" method="get">
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

                @if(Auth::user()->state == 3)
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
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            选择公司
                                          </span>
                                        </div>
                                      <select name="company" class="form-control">
                                        <option value="">---选择公司---</option>
                                                 @foreach($companys as $c)
                                                <option value="{{$c->id}}" @if($company==$c->id) selected @endif>{{$c->company_name}}</option>
                                            @endforeach
                                      </select>
                                    </div>
                                </div>

                                @endif
                                <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                    <button type="submit" class="btn btn-primary btn-sm">提交</button>&nbsp;
                                </div>
                </form>
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
        </section>
    </div>
    <!-- /. PAGE INNER  -->
@stop

@section('scripts')

<script>

</script>
@stop