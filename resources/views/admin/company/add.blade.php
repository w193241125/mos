@extends('admin.layouts.app')

@section('title')
    公司列表
@stop

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="page-header">
                添加公司 &nbsp;&nbsp;<a href="/admin/company/" style="font-size: 18px;">返回列表</a>
            </h1>

        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="table-responsive">
                                <form action="/admin/company/doadd" method="post" >
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                公司名称
                                              </span>
                                            </div>
                                            <input type="text" name="company_name" class="form-control" placeholder="请输入商家名称" required>
                                        </div>
                                        &nbsp;
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                公司代号
                                              </span>
                                            </div>
                                            <input type="text" name="code_name" class="form-control" placeholder="请输入公司代号（只能是字母或数字）" >
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

