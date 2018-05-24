@extends('admin.layouts.app')

@section('title')
    添加食物
@stop

@section('content')

    <div id="page-wrapper" >
        <div class="header">
            <h1 class="page-header">
                添加食物 <small>Responsive tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">主页</a></li>
                <li><a href="#">食物设置</a></li>
                <li class="active">添加食物</li>
            </ol>

        </div>

        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            添加食物
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form action="/admin/food/doadd" method="post">
                                    {{ csrf_field() }}
                                    <div class="panel-body">

                                        <div class="sub-title">所属商家</div>
                                        <div>
                                            <select class="selectbox" name="sid" style="width: auto;">
                                                @foreach($shop as $s)
                                                <option value="{{$s->sid}}">{{$s->sname}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="sub-title">食物名称</div>
                                        <div>
                                            <input type="text" name="fname" class="form-control" placeholder="请输入食物名称" required>
                                        </div>
                                        <div class="sub-title">价格</div>
                                        <div>
                                            <input type="number" name="price" class="form-control" step="0.1" placeholder="格式: 20" required>
                                        </div>
                                        <div class="sub-title">是否在设置菜单时自动勾选</div><span style="color:red;">* 选`是`之后会在设置菜单时自动勾选此食物, 建议饮料,米饭选`是`, 其它按需;</span>
                                        <div>
                                            <input type="radio" name="ischecked" class="radio3" value="1" checked>否
                                            <input type="radio" name="ischecked" class="radio3" value="2" >是
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

@section('scripts')
    <script>

    </script>
    @stop


