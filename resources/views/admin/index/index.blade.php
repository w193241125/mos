@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="page-header">
                350点餐系统 <small>后台</small>
            </h1>
        </div>

      <section class="content">
      <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                欢迎来到350点餐后台,点击左上角返回前台哦~
                            </div>

                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
            <!-- /. ROW  -->
            @if(!empty($repeat))
            <h1 style="color:red" >有重复订单！！！</h1>
            <h1 style="color:red" >有重复订单！！！</h1>
            <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>用户ID</th>
                                <th>日期</th>
                                <th>金额</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($repeat as $r)
                                <tr class="gradeA">
                                    <td class="selectId">
                                        {{$r->uname}}
                                    </td>
                                    <td class="selectId">
                                        {{$r->date}}
                                    </td>
                                    <td class="selectId">
                                        {{$r->total}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </section>
    </div>
    <!-- /. PAGE INNER  -->
@stop