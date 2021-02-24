@extends('admin.layouts.app')

@section('title')
    添加食物
@stop

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="page-header">
                编辑食物&nbsp;&nbsp;<a href="javascript:history.go(-1);" style="font-size: 14px;" class="btn btn-xs btn-info">返回</a>
            </h1>


        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form action="/admin/food/doedit" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="fid" value="{{$food->fid}}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            所属商家
                                          </span>
                                        </div>
                                        <select name="sid" class="form-control">
                                            <option value="0" >--请选择--</option>
                                            @foreach($shop as $s)
                                                <option value="{{$s->sid}}" {{$s->sid == $food->sid?'selected':''}}>{{$s->sname}}</option>
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
                                        <input type="text" name="fname" class="form-control" value="{{$food->fname}}" placeholder="请输入食物名称" required>
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
                                            <option value="1" {{$food->ftype == 1?'selected':''}}>菜</option>
                                            <option value="2" {{$food->ftype == 2?'selected':''}}>饭</option>
                                            <option value="3" {{$food->ftype == 3?'selected':''}}>饮料</option>
                                        </select>
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        价格
                                      </span>
                                    </div>
                                    <input type="number" name="price" class="form-control" step="0.1" placeholder="格式: 20" value="{{$food->price}}" required>
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            自动勾选
                                          </span>
                                        </div>
                                        &nbsp;&nbsp;<label for="yes"><input type="radio" name="ischecked" class="radio3" value="1" id="yes" {{$food->ischecked == 1?'checked':''}}>否</label>
                                        &nbsp;&nbsp;<label for="no"><input type="radio" name="ischecked" class="radio3" value="2" id="no" {{$food->ischecked == 2?'checked':''}}>是</label>
                                        &nbsp;&nbsp;&nbsp;<span style="color:red;">* 选`是`之后会在设置菜单时自动勾选此食物, 建议饮料,米饭选`是`, 其它按需;</span>
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            是否启用
                                          </span>
                                        </div>
                                        &nbsp;&nbsp;<label for="qy"><input type="radio" name="fstate" class="radio3" value="1" id="qy" {{$food->fstate == 1?'checked':''}}>启用</label>
                                        &nbsp;&nbsp;<label for="jy"><input type="radio" name="fstate" class="radio3" value="2" id="jy" {{$food->fstate == 2?'checked':''}}>禁用</label>
                                    </div>
                                    &nbsp;
                                    <div class="sub-title"></div>
                                    <button type="submit" class="btn btn-info">确认修改</button>
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

