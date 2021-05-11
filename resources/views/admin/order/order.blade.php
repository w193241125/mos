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
        <h4>批量取消:</h4>
            <ol class="breadcrumb">
                <li></li><br>
                <li>
                    <form action="/admin/order/" method="get" class="form-inline">
                        <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                <div class="input-group">
                                <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        选择公司
                                      </span>
                                    </div>
                                      <select name="company" class="form-control" id="company">

                                                <option value="666">--全部--</option>
                                                 @foreach($companys as $c)
                                                <option value="{{$c->id}}" @if($company==$c->id) selected @endif>{{$c->company_name}}</option>
                                            @endforeach
                                      </select>
                                    </div>
                                    </div>

                        <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    时间(餐):
                                  </span>
                                </div>
                                   <select name="time_mark" id="time_tmark" class="form-control">
                                    <option value="">---请选择---</option>
                                    @foreach($type as $t)
                                        <option value="{{$t->tmark}}">{{$t->tname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="input-group mb-1 col-lg-2 col-md-3 col-sm-6">
                            <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                时间(天)
                              </span>
                            </div>
                            <input type="text" name="date"  class="form-control float-right" id="date_for_cancel" value="{{$date or ''}}">
                          </div>
                        </div>
                        <a href="javascript:;" onclick="cancelOrder();" class="btn btn-info right">取消订单</a>
                        <br>
                        <span style="color:red"> &nbsp;****************  </span><span style="font-weight:bold">时间(天)选了就会取消整天的餐, 只取消一餐的话,只选时间(餐)就好</span><span style="color:red">******* </span>
                    </form>
                    </li>
            </ol>
        &nbsp;
        <h1 class="page-header">
            本周订单列表
        </h1>
        </div>
        <script>
            function cancelOrder() {
                var tmark = $('#time_tmark ').val();
                var company = $('#company ').val();
                var date_ = $('#date_for_cancel ').val();

                if(tmark != '' && date_ !=''){
                    alert('时间二选一哦!')
                    return;
                }
                if(tmark == '' && date_ ==''){
                    alert('请选择时间!')
                    return;
                }
                if(company == undefined || company == ''){
                    alert('请选择公司!')
                    return;
                }
                if (confirm("确认取消吗?请谨慎操作!")) {
                    $.ajax({
                        type: "POST",//方法类型
                        dataType: "json",//预期服务器返回的数据类型
                        url: "/admin/cancelOrder/" ,//url
                        data: {tmark:tmark, company:company, date:date_},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            // console.log(result);//打印服务端返回的数据(调试用)
                            if (result.cose == 200) {
                                alert(result.msg);
                                location.reload();
                            }else{
                                alert(result.msg);
                            }
                        },
                        error : function(result) {
                            alert("取消失败！所选时间不能取消或者登陆状态超时!");
                            location.reload();
                        }
                    });
                }
            }
        </script>

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <form action="/admin/order/" class="form-inline" method="get" >
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
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            编号
                                          </span>
                                        </div>
                                        <input type="number" name="uname" placeholder="请输入用户编号" class="small" min="1" value="{{$uname or NULL}}"/>
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
                                <div class="input-group mb-1 col-lg-2 col-md-4 col-sm-6">
                                    <button type="submit" class="btn btn-info btn-sm">提交</button>&nbsp;
                                    <a href="/admin/order/export/1/1" class="btn btn-info right">导出本周Excel表</a>
                                </div>
                            </form>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped  table-head-fixed text-nowrap table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>用户编号</th>
                                        <th>用户名称</th>
                                        <th>商家</th>
                                        <th>食物</th>
                                        <th>订单类型</th>
                                        <th>价格</th>
                                        <th>下单时间</th>
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
        $('#date_for_cancel').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "startDate": moment(),
            "locale": {
                "format":'YYYY-MM-DD',
                "daysOfWeek": daterangepicker_config.daysOfWeek,
                "monthNames": daterangepicker_config.monthNames,
                "applyLabel": "确认",
                "cancelLabel": "清空",
            }
        });

        $(function(){
            $('#date_for_cancel').on('cancel.daterangepicker', function(ev, picker) {
                //做点什么，比如清除输入
                $('#date_for_cancel').val('');
            });
          $('#date_for_cancel').val('');
        });
    </script>
    @stop