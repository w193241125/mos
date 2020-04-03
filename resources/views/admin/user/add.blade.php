@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div id="page-wrapper" >
        <div class="header">
            <h1 class="page-header">
                用户列表 <small>Responsive tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">主页</a></li>
                <li><a href="#">用户设置</a></li>
                <li class="active">添加用户</li>
            </ol>

        </div>

        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            添加用户
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form action="/admin/user/doadd" method="post">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="sub-title">所属公司</div>
                                        <div >
                                            <select name="company" id="selectcompany" style="width: 160px">
                                                <option value="0" >--请选择--</option>
                                                <option value="1">三五零</option>
                                                <option value="2">旭力</option>
                                                <option value="3">瑞鲨</option>
                                                <option value="4">牛越</option>
                                            </select>
                                        </div>
                                        <div class="sub-title">用户名(上一个:{{$uid}})</div>
                                        <div>
                                            <input type="text" id="uname" name="uname" class="form-control" placeholder="请输入用户名" required value="">
                                        </div>
                                        <div class="sub-title">真实姓名</div>
                                        <div>
                                            <input type="text" name="realname" class="form-control" placeholder="请输入真实姓名" required>
                                        </div>
                                        <div class="sub-title">密码</div>
                                        <div>
                                            <input type="text" name="password" class="form-control" placeholder="不填则默认为123456" >
                                        </div>

                                        <div class="sub-title">是否启用</div>
                                        <div>
                                            <input type="radio" name="state" class="radio3" value="1" checked>启用
                                            <input type="radio" name="state" class="radio3" value="2">禁用
                                            <input type="radio" name="state" class="radio3" value="3">管理员
                                            <input type="radio" name="state" class="radio3" value="4">商家
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
