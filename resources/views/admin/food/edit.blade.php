@extends('admin.layouts.app')

@section('title')
    添加食物
@stop

@section('content')

    <div id="page-wrapper" >
        <div class="header">
            <h1 class="page-header">
                编辑食物 <small>Responsive tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">主页</a></li>
                <li><a href="#">食物设置</a></li>
                <li class="active">编辑食物</li>
            </ol>

        </div>

        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a href="javascript:history.go(-1);" class="btn btn-primary btn-toolbar ">返回</a>
                            <div class="table-responsive">
                                <form action="/admin/food/doedit" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="fid" value="{{$food->fid}}">
                                    <div class="panel-body">
                                        <div class="sub-title">所属商家</div>
                                        <div>
                                            <select class="selectbox" name="sid" style="width: auto;">
                                                @foreach($shop as $s)
                                                <option value="{{$s->sid}}" {{$s->sid == $food->sid?'selected':''}}>{{$s->sname}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="sub-title">食物名称</div>
                                        <div>
                                            <input type="text" name="fname" class="form-control" value="{{$food->fname}}" required>
                                        </div>
                                        <div class="sub-title">价格</div>
                                        <div>
                                            <input type="number" name="price" step="0.1" class="form-control" value="{{$food->price}}" required>
                                        </div>
                                        <div class="sub-title">是否在设置菜单时自动勾选</div><span style="color:red;">* 选`是`之后会在设置菜单时自动勾选此食物, 建议饮料,米饭选`是`, 其它按需;</span>
                                        <div>
                                            <input type="radio" name="ischecked" class="radio3" value="1" {{$food->ischecked == 1?'checked':''}}>否
                                            <input type="radio" name="ischecked" class="radio3" value="2" {{$food->ischecked == 2?'checked':''}}>是
                                        </div>
                                        <div class="sub-title">是否启用</div>
                                        <div>
                                            <input type="radio" name="state" class="radio3" value="1" {{$food->fstate == 1?'checked':''}}>启用
                                            <input type="radio" name="state" class="radio3" value="2" {{$food->fstate == 2?'checked':''}}>禁用
                                        </div>

                                        <div class="sub-title"></div>
                                        <button type="submit" class="btn btn-default">确认修改</button>
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

