@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="page-header">
                用户列表 &nbsp;&nbsp;<a href="javascript:history.go(-1);" style="font-size: 14px;" class="btn btn-xs btn-info">返回</a>
            </h1>
        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <div class="table-responsive">
                                <form action="/admin/user/doedit" method="post">
                                    <input type="hidden" name="uid" value="{{$user->uid}}">
                                    {{ csrf_field() }}
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            所属公司
                                          </span>
                                        </div>
                                        <select name="company" class="form-control" id="company">
                                                <option value="0">--请选择--</option>
                                                 @foreach($companys as $c)
                                                <option value="{{$c->id}}" @if($company==$c->id) selected @endif>{{$c->company_name}}</option>
                                            @endforeach
                                      </select>
                                    </div>
                                       &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            用户名
                                          </span>
                                        </div>
                                        <input type="text" name="uname" class="form-control" placeholder="请输入用户名" value="{{$user->uname}}"  required>
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            真实姓名
                                          </span>
                                        </div>
                                        <input type="text" name="realname" class="form-control" placeholder="请输入真实姓名" value="{{$user->realname}}" required>
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            密码
                                          </span>
                                        </div>
                                        <input type="text" name="password" class="form-control" placeholder="不修改则留空" >
                                    </div>
                                    &nbsp;

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            是否启用
                                          </span>
                                        </div>
                                        &nbsp;&nbsp;<label for="qy"><input type="radio" name="state" class="radio3" value="1" id="qy" {{$user->state==1?'checked':''}}>启用</label>
                                        &nbsp;&nbsp;<label for="jy"><input type="radio" name="state" class="radio3" value="2" id="jy" {{$user->state==2?'checked':''}}>禁用</label>
                                        &nbsp;&nbsp;<label for="gly"><input type="radio" name="state" class="radio3" value="3" id="gly" {{$user->state==3?'checked':''}}>管理员</label>
                                        &nbsp;&nbsp;<label for="sj"><input type="radio" name="state" class="radio3" value="4" id="sj" {{$user->state==4?'checked':''}}>商家</label>
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

