@extends('admin.layouts.app')

@section('title')
    添加食物
@stop

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="page-header">
                添加食物&nbsp;&nbsp;<a href="/admin/food/" style="font-size: 18px;">返回列表</a>
            </h1>
        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form action="/admin/food/doadd" method="post">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            所属商家
                                          </span>
                                        </div>
                                        <select name="sid" class="form-control">
                                            <option value="0" >--请选择--</option>
                                            @foreach($shop as $s)
                                                <option value="{{$s->sid}}">{{$s->sname}}</option>
                                                    @endforeach
                                        </select>
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            食物名称
                                          </span>
                                        </div>
                                        <input type="text" name="fname" class="form-control" placeholder="请输入食物名称" required>
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            食物分类
                                          </span>
                                        </div>
                                        <select name="ftype" class="form-control">
                                            <option value="0">--食物分类--</option>
                                            <option value="1" selected >菜</option>
                                            <option value="2" >饭</option>
                                            <option value="3" >饮料</option>
                                        </select>
                                    </div>
                                    &nbsp;
                                   <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        价格
                                      </span>
                                    </div>
                                    <input type="number" name="price" class="form-control" step="0.1" placeholder="格式: 20" required>
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            自动勾选
                                          </span>
                                        </div>
                                        &nbsp;&nbsp;<label for="yes"><input type="radio" name="ischecked" class="radio3" value="1" id="yes" checked>否</label>
                                        &nbsp;&nbsp;<label for="no"><input type="radio" name="ischecked" class="radio3" value="2" id="no">是</label>
                                        &nbsp;&nbsp;&nbsp;<span style="color:red;">* 选`是`之后会在设置菜单时自动勾选此食物, 建议饮料,米饭选`是`, 其它按需;</span>
                                    </div>
                                        &nbsp;

                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            是否启用
                                          </span>
                                        </div>
                                        &nbsp;&nbsp;<label for="qy"><input type="radio" name="fstate" class="radio3" value="1" id="qy" checked>启用</label>
                                        &nbsp;&nbsp;<label for="jy"><input type="radio" name="fstate" class="radio3" value="2" id="jy">禁用</label>
                                    </div>
                                        &nbsp;

                                        <div class="sub-title"></div>
                                        <button type="submit" class="btn btn-info">确认添加</button>
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

@section('scripts')
    <script>

    </script>
    @stop


