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
                <li><h3>批量取消:</h3></li>
                    <form action="/admin/order/" method="get" class="list-inline">
                        <label for="date" >
                        公司:<select name="company" id="company">
                            <option value="">---请选择---</option>
                            <option value="666">全部</option>
                            <option value="1">350</option>
                            <option value="2">旭力</option>
                            <option value="3">瑞鲨</option>
                            <option value="4">牛越</option>
                            <option value="5">XT</option>
                        </select>
                        </label>
                        <label for="time_tmark" >
                        时间(餐):<select name="time_mark" id="time_tmark">
                            <option value="">---请选择---</option>
                            @foreach($type as $t)
                                <option value="{{$t->tmark}}">{{$t->tname}}</option>
                            @endforeach
                        </select>
                        </label>
                        <label for="date" >
                            <small><span class="">时间(天)：</span><input class="layui-input" type="text" id="date" name="date" placeholder="yyyy-MM-dd" lay-key="1" value="{{$rdate or ''}}"></small>
                        </label>
                        <a href="javascript:;" onclick="cancelOrder();" class="btn btn-info right">取消订单</a>
                        <br><span style="color:red"> &nbsp;****************  </span><span style="font-weight:bold">时间(天)选了就会取消整天的餐, 只取消一餐的话,只选时间(餐)就好</span><span style="color:red">******* </span>
                    </form>
            </ol>
        </div>
        <script>
            function cancelOrder() {
                var tmark = $('#time_tmark ').val();
                var company = $('#company ').val();
                var date_ = $('#date ').val();

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

        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <form action="/admin/order/" method="get" class="list-inline">

                                时间:<select name="tmark" id="">
                                    <option value="">---请选择---</option>
                                    @foreach($type as $t)
                                    <option value="{{$t->tmark}}" @if($t->tmark == $tmark) selected @endif>{{$t->tname}}</option>
                                    @endforeach
                                </select>
                                &nbsp;商家:<select name="sid" id="">
                                    <option value="">---全部---</option>
                                    @foreach($shop as $s)
                                        <option value="{{$s->sid}}" @if($s->sid == $sid) selected @endif>{{$s->sname}}</option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-info right">查询</button>
                                <a href="/admin/order/export/1/1" class="btn btn-info right">导出本周Excel表</a>
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
                                {{ $order->appends(['tmark'=>$tmark,'sid'=>$sid])->links() }}
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
            ,min:1
            ,range: true
        });

    </script>
    @stop