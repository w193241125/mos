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
                                <form action="/admin/menu/doadd" method="post">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="sub-title">选择商家</div>
                                        <div id="domark">
                                            <select class="selectbox" name="sid" style="width: auto;" id="selectshop">
                                                <option value="">--请选择商家--</option>
                                                @foreach($shop as $s)
                                                    <option value="{{$s->sid}}" {{$s->sid == $menu->sid?'selected':''}}>{{$s->sname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="sub-title">选择食物</div>
                                        <div id="getFromAjax">
                                            @foreach($food as $f)
                                                <input  type="checkbox" name="fid[]" class="checkbox3" value="{{$f->fid}}" {{in_array($f->fid,$fidArr)?'checked':''}}> :{{$f->fname}}
                                                @endforeach
                                        </div>
                                        <div class="sub-title">选择设置时间</div>
                                        <div>
                                            @foreach($type as $t)
                                            <input type="radio" name="tmark" class="checkbox3" value="{{$t->tmark}}" {{$t->tmark == $menu->tmark?'checked':''}} >{{$t->tname}}
                                            @endforeach
                                        </div>
                                        <div class="sub-title">设置周</div>
                                        <div>
                                            <input type="radio" name="mweek" class="radio3" value="1" {{$menu->mweek == 1?'checked':''}}>本周
                                            <input type="radio" name="mweek" class="radio3" value="2" {{$menu->mweek == 2?'checked':''}}>下周
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
                    var foodData = data.food;
                    console.log(data);
                    $('#getFromAjax').empty();
                    for(var index in data){
                        var fid = data[index].fid;
                        var fname = data[index].fname;
                        var price = data[index].price;
                        $("#getFromAjax").append('<input type="checkbox" name="fid[]" class="checkbox3" {{$t->tmark == $menu->tmark?\'checked\':\'\'}} value="'+fid+'">'+fname);
                        // console.log(fid)
                    }
                }
            });
        })
    </script>
    @stop