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
                按日统计 <small>默认显示本月</small>
            </h1>
        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                            <form action="/admin/order_summary" class="form-inline" method="get">

                                <div class="input-group mb-1 col-lg-2  col-md-4 col-sm-6">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        开始时间
                                      </span>
                                    </div>
                                    <input type="text" name="date"  class="form-control float-right" id="date" value="{{$date or ''}}">
                                  </div>
                                </div>

                                <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
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
                                        <option value="1" @if($company==1) selected @endif>350</option>
                                        <option value="2" @if($company==2) selected @endif>旭力</option>
                                        <option value="3" @if($company==3) selected @endif>瑞鲨</option>
                                        <option value="4" @if($company==4) selected @endif>牛越</option>
                                        <option value="5" @if($company==5) selected @endif>XT</option>
                                      </select>
                                    </div>
                                    </div>

                                @endif
                                <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                    <button type="submit" class="btn btn-primary btn-sm">提交</button>&nbsp;
                                    <a href="javascript:;" id="export" class="btn btn-info btn-sm" data-toggle="tooltip"  title="默认本月,选择时间查询后可导出时间段订单">导出Excel表</a>
                                </div>
                            </form>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>日期</th>
                                        <th>数量</th>
                                        <th>金额</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($total as $d)
                                        <tr class="gradeA">
                                            <td>汇总</td>
                                            <td>{{$d->num}}</td>
                                            <td>{{$d->total}} </td>
                                        </tr>
                                    @endforeach
                                    @foreach($dayOrder as $d)
                                        <tr class="gradeA">
                                            <td>{{$d->date}}</td>
                                            <td>{{$d->num}}</td>
                                            <td>{{$d->total}} </td>
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

        $('#export').on('click',function () {
            date = $('#date').val()
            dates = $('#dates').val()
            sid = $('#sid option:selected').val()
            company = $('#company option:selected').val()
            window.location.href = "/admin/export_summary/?date="+date+"&dates="+dates+"&company="+company+"&sid="+sid
        })
    </script>
@stop