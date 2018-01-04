@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div id="page-wrapper" >
        <div class="header">
            <h1 class="page-header">
                菜单添加 <small>Responsive tables</small>
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
                            添加菜单
                        </div>
                        <div class="panel-body">
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    <strong> {{session('error')}}</strong>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <form id="form1" onsubmit="return false" action="##" method="post">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="sub-title">选择商家</div>
                                        <div id="domark">
                                            <select class="selectbox" name="sid" style="width: auto;" id="selectshop">
                                                <option value="">--请选择商家--</option>
                                                @foreach($shop as $s)
                                                    <option value="{{$s->sid}}">{{$s->sname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="sub-title">选择食物</div>
                                        <div id="getFromAjax">
                                            选择商家后显示!
                                        </div>
                                        <div class="sub-title">选择设置时间</div>
                                        <div>
                                            @foreach($type as $t)
                                            <input type="radio" name="tmark" class="checkbox3" value="{{$t->tmark}}">{{$t->tname}}
                                            @endforeach
                                        </div>
                                        <div class="sub-title">该时间的菜单</div>
                                        <div id="getMenuByAjax">
                                            <span style="color: red">暂无</span>
                                        </div>
                                        <div class="sub-title">本周/下周</div>
                                        <div>
                                            <input type="radio" name="mweek" class="radio3" value="1" >本周
                                            <input type="radio" name="mweek" class="radio3" value="2" checked>下周
                                        </div>
                                        <div class="sub-title">设置状态</div>
                                        <div>
                                            <input type="radio" name="mstate" class="radio3" value="1" checked>启用
                                            <input type="radio" name="mstate" class="radio3" value="2">禁用
                                        </div>

                                        <div class="sub-title"></div>
                                        <button type="submit" onclick="ajaxAdd()" class="btn btn-default">确认添加</button>
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
        $("#selectshop").change(function () {
            sid = $("#selectshop  option:selected").val();
            $.ajax({
                type: "get",
                url: "/admin/menu/ajaxReq/"+sid,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    var i = 1;
                    var foodData = data.food;
                    $('#getFromAjax').empty();
                    for(var index in data){
                        var fid = data[index].fid;
                        var fname = data[index].fname;
                        var price = data[index].price;
                        if(tmp != undefined && tmp != price){
                            $("#getFromAjax").append('<br/>')
                            $("#getFromAjax").append('<br/>')
                        }
                        $("#getFromAjax").append('<input id="checkbox-fa-light-'+i+'" type="checkbox"  name="fid[]"  value="'+fid+'">'+'<lable for="checkbox-fa-light-'+i+'">'+fname+ price+'元</lable>&nbsp;');
                        var tmp = price;
                        // console.log(fid)
                        i++;
                    }
                }
            });
        });
        //监控tmark checkeded改变,ajax提交查询商家某个时间菜单
        $('input[name=tmark]').change(function () {
           var sid = $('#selectshop option:selected').val();
           var tmark = $('input[name=tmark]:checked').val();
           var mweek = $('input[name=mweek]:checked').val();
            $.ajax({
                type: "get",
                url: "/admin/menu/ajaxFind/"+sid+'/'+tmark+'/'+mweek,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    if(data.length != 0){
                        var foodData = data.food;
                        $('#getMenuByAjax').empty();
                        for(var index in data){
                            var fname = data[index].list;
                            var price = data[index].price;
                            $("#getMenuByAjax").append('<span style="color: red">'+fname+'</span>');
                        }
                    }else{
                        $('#getMenuByAjax').empty();
                        $("#getMenuByAjax").append('<span style="color: red">暂无</span>');
                    }
                }
            });
        });
        //监控mweek checkeded改变,ajax提交查询商家某个时间菜单
        $('input[name=mweek]').change(function () {
            var sid = $('#selectshop option:selected').val();
            var tmark = $('input[name=tmark]:checked').val();
            var mweek = $('input[name=mweek]:checked').val();
            $.ajax({
                type: "get",
                url: "/admin/menu/ajaxFind/"+sid+'/'+tmark+'/'+mweek,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    if(data.length != 0){
                        var foodData = data.food;
                        $('#getMenuByAjax').empty();
                        for(var index in data){
                            var fname = data[index].list;
                            var price = data[index].price;
                            $("#getMenuByAjax").append('<span style="color: red">'+fname+'</span>');
                        }
                    }else{
                        $('#getMenuByAjax').empty();
                        $("#getMenuByAjax").append('<span style="color: red">暂无</span>');
                    }
                }
            });
        });
        //监控selected改变,ajax提交查询商家某个时间菜单
        $('#selectshop').change(function () {
            var sid = $('#selectshop option:selected').val();
            var tmark = $('input[name=tmark]:checked').val();
            var mweek = $('input[name=mweek]:checked').val();
            $.ajax({
                type: "get",
                url: "/admin/menu/ajaxFind/"+sid+'/'+tmark+'/'+mweek,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    if(data.length != 0){
                        var foodData = data.food;
                        $('#getMenuByAjax').empty();
                        for(var index in data){
                            var fname = data[index].list;
                            var price = data[index].price;
                            $("#getMenuByAjax").append('<span style="color: red">'+fname+'</span>');
                        }
                    }else{
                        $('#getMenuByAjax').empty();
                        $("#getMenuByAjax").append('<span style="color: red">暂无</span>');
                    }
                }
            });
        });

        //ajax提交增加
        function ajaxAdd(){
            $.ajax({
                type: "POST",//方法类型
                dataType: "json",//预期服务器返回的数据类型
                url: "/admin/menu/doadd" ,//url
                data: $('#form1').serialize(),
                success: function (result) {
                    console.log(result);//打印服务端返回的数据(调试用)
                    if (result.menuMsg == 1) {
                        alert("添加成功");
                    }
                },
                error : function() {
                    alert("添加失败！");
                }
            });
        }
    </script>
    @stop