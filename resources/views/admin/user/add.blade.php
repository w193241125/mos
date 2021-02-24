@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="page-header">
                添加用户&nbsp;&nbsp;<a href="/admin/user/" style="font-size: 18px;">返回列表</a>
            </h1>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">

                        <div class="panel-body">
                                <form action="/admin/user/doadd" method="post">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            所属公司
                                          </span>
                                        </div>
                                        <select name="company" class="form-control">
                                            <option value="0" >--请选择--</option>
                                            <option value="1">三五零</option>
                                            <option value="2">旭力</option>
                                            <option value="3">瑞鲨</option>
                                            <option value="4">牛越</option>
                                            <option value="5">XT</option>
                                        </select>
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            用户名
                                          </span>
                                        </div>
                                        <input type="text" id="uname" name="uname" class="form-control" placeholder="三五零:{{$uid}}, 牛越:{{$ny_uid}}, XT:{{$xt_uid}}" required value="">
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            真实姓名
                                          </span>
                                        </div>
                                        <input type="text" name="realname" class="form-control" placeholder="请输入真实姓名" required>
                                    </div>
                                    &nbsp;
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            密码
                                          </span>
                                        </div>
                                        <input type="text" name="password" class="form-control" placeholder="不填则默认为123456" >
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
                                        &nbsp;&nbsp;<label for="gly"><input type="radio" name="state" class="radio3" value="3" id="gly">管理员</label>
                                        &nbsp;&nbsp;<label for="sj"><input type="radio" name="state" class="radio3" value="4" id="sj">商家</label>
                                    </div>
                                        &nbsp;
                                    <div class="sub-title"></div>
                                    <button type="submit" class="btn btn-info">确认添加</button>
                                </form>

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
        //ajax提交查询商家食物列表
        $("#selectcompany").change(function () {
            cid = $("#selectcompany  option:selected").val();
            console.log(cid)
            $.ajax({
                type: "get",
                url: "/admin/user/ajaxReq/"+cid,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    $('#uname').val(data);

                }
            });
        });
    </script>
@endsection
