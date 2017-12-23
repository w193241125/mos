@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div id="page-wrapper" >
        <div class="header">
            <h1 class="page-header">
                商家列表 <small>Responsive tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">主页</a></li>
                <li><a href="#">商家设置</a></li>
                <li class="active">添加商家</li>
            </ol>

        </div>

        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            添加商家
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form action="/admin/shop/doadd" method="post">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="sub-title">商家名称</div>
                                        <div>
                                            <input type="text" name="sname" class="form-control" placeholder="请输入商家名称" required>
                                        </div>
                                        <div class="sub-title">商家地址</div>
                                        <div>
                                            <input type="text" name="address" class="form-control" placeholder="请输入商家地址">
                                        </div>
                                        <div class="sub-title">商家联系方式</div>
                                        <div>
                                            <input type="text" name="phone" class="form-control" placeholder="请输入商家联系方式">
                                        </div>
                                        <div class="sub-title">点餐限制金额</div>
                                        <div>
                                            <input type="number" name="limit_money" class="form-control" placeholder="格式: 20" required>
                                        </div>
                                        <div class="sub-title">是否启用</div>
                                        <div>
                                            <input type="radio" name="state" class="radio3" value="1" checked>启用
                                            <input type="radio" name="state" class="radio3" value="2">禁用
                                        </div>

                                        <div class="sub-title"></div>
                                        <button type="submit" class="btn btn-default">确认添加</button>
                                    </div>
                                </form>
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

