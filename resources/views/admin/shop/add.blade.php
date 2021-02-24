@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="page-header">
                添加商家 &nbsp;&nbsp;<a href="/admin/shop/" style="font-size: 18px;">返回列表</a>
            </h1>

        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="table-responsive">
                                <form action="/admin/shop/doadd" method="post" class="form-inline">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                商家名称
                                              </span>
                                            </div>
                                            <input type="text" name="sname" class="form-control" placeholder="请输入商家名称" required>
                                        </div>
                                        &nbsp;
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                供餐
                                              </span>
                                            </div>
                                            <select name="type" class="form-control">
                                                <option value="">---请选择---</option>
                                                <option value="1" >早餐</option>
                                                <option value="1" >中晚餐</option>
                                            </select>
                                        </div>
                                        &nbsp;
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                商家地址
                                              </span>
                                            </div>
                                            <input type="text" name="address" class="form-control" placeholder="请输入商家地址" >
                                        </div>
                                        &nbsp;
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                商家联系方式
                                              </span>
                                            </div>
                                            <input type="text" name="phone" class="form-control" placeholder="请输入商家联系方式">
                                        </div>
                                        &nbsp;
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                点餐限制金额
                                              </span>
                                            </div>
                                            <input type="number" name="limit_money" class="form-control" placeholder="格式: 20" required>
                                        </div>
                                        &nbsp;
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                是否启用
                                              </span>
                                            </div>
                                            &nbsp;&nbsp;<label for="qy"><input type="radio" name="state" class="radio3" value="1" id="qy" checked>启用</label>
                                            &nbsp;&nbsp;<label for="jy"><input type="radio" name="state" class="radio3" value="2" id="jy">禁用</label>
                                        </div>
                                        &nbsp;
                                        <div class="sub-title"></div>
                                        <button type="submit" class="btn btn-info">确认添加</button>
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

