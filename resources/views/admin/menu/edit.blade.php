@extends('admin.layouts.app')

@section('title')
    商家列表
@stop

@section('content')

    <div id="page-wrapper" >
        <div class="header">
            <h1 class="page-header">
                菜单编辑 <small>Responsive tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#">主页</a></li>
                <li><a href="#">菜单设置</a></li>
                <li class="active">编辑菜单</li>
            </ol>

        </div>

        <div id="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a href="javascript:history.go(-1);" class="btn btn-primary btn-toolbar ">返回</a>
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    <strong> {{session('error')}}</strong>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <form action="/admin/menu/doedit" method="post">
                                    <input type="hidden" name="mid" value="{{$menu->mid}}">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="sub-title" >选择商家 <span style="color:red">*选择第一个选项后,再重新选择商家, 可以重置菜单, 并勾选预设了`设置菜单时勾选`的食物哦</span></div>
                                        <div id="domark">
                                            <select class="selectbox" name="sid" style="width: auto;" id="selectshop">
                                                <option value="">--请选择商家--</option>
                                                @foreach($shop as $s)
                                                    <option value="{{$s->sid}}" {{$s->sid == $menu->sid?'selected':''}}>{{$s->sname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="sub-title">选择食物 &nbsp;&nbsp;&nbsp;<button type="button" id="clear" class="btn btn-default btn-sm">清空</button>
                                            <button type="button" id="selectall" class="btn btn-default btn-sm">全选</button></div></div>
                                        <div id="getFromAjax">
                                            @foreach($food as $f)
                                                <label for="foods{{$f->fid}}"><input id="foods{{$f->fid}}" type="checkbox" name="fid[]" class="checkbox3" value="{{$f->fid}}" @if(in_array($f->fid,$fidArr)||$f->ischecked==2) checked @endif> <span style="color: #0a689d">{{$f->fname}}</span><span style="color: red">{{$f->price}}</span> <span style="color: #0a689d">元，</span></label>
                                                @endforeach
                                        </div>
                                        <div class="sub-title">选择设置时间</div>
                                        <div>
                                            @foreach($type as $t)
                                                <label for="radio{{$t->tmark}}"><input id="radio{{$t->tmark}}" type="radio" name="tmark" class="checkbox3" value="{{$t->tmark}}" {{$t->tmark == $menu->tmark?'checked':''}} >{{$t->tname}}，</label>
                                            @endforeach
                                        </div>
                                        <div class="sub-title">本周/下周</div>
                                        <div>
                                            <label for="radioThis"><input id="radioThis" type="radio" name="mweek" class="radio3" value="1" {{$menu->mweek == 1?'checked':''}} >本周</label>
                                            <label for="radioNext"><input id="radioNext" type="radio" name="mweek" class="radio3" value="2" {{$menu->mweek == 2?'checked':''}}>下周</label>
                                        </div>
                                        <div class="sub-title">设置状态</div>
                                        <div>
                                            <label for="radioUse"><input id="radioUse" type="radio" name="mstate" class="radio3" value="1" {{$menu->mstate == 1?'checked':''}}>启用</label>
                                            <label for="radioBan"><input id="radioBan" type="radio" name="mstate" class="radio3" value="2" {{$menu->mstate == 2?'checked':''}}>禁用</label>
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

@section('scripts')
    <script>
        $('#clear').on('click',function(){
            $('input:checkbox').prop('checked', false).removeAttr('checked')
        })
        $('#selectall').on('click',function(){
            $('input:checkbox').prop('checked', true)
        })

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
                        var ischecked = data[index].ischecked;
                        var fname = data[index].fname;
                        var price = data[index].price;
                        if(tmp != undefined && tmp != price){
                            $("#getFromAjax").append('<br/>')
                            $("#getFromAjax").append('<br/>')
                        }
                        if(ischecked == 1){
                            $("#getFromAjax").append('<input  id="checkbox-fa-light-'+i+'" type="checkbox"  name="fid[]"  value="'+fid+'">'+'<label for="checkbox-fa-light-'+i+'"><span style="color: #0a689d">'+fname+'</span>'+'<span style="color: red">'+ price+'</span><span style="color: #0a689d">元</span>，</label>&nbsp;');
                        }else{
                            $("#getFromAjax").append('<input  id="checkbox-fa-light-'+i+'" type="checkbox"  name="fid[]" checked  value="'+fid+'">'+'<label for="checkbox-fa-light-'+i+'"><span style="color: #0a689d">'+fname+'</span>'+'<span style="color: red">'+ price+'</span><span style="color: #0a689d">元</span>，</label>&nbsp;');
                        }
//                        $("#getFromAjax").append('<input id="checkbox-fa-light-'+i+'" type="checkbox"  name="fid[]"  value="'+fid+'">'+'<lable for="checkbox-fa-light-'+i+'">'+fname+ price+'元</lable>&nbsp;');
                        var tmp = price;
                        // console.log(fid)
                        i++;
                    }
                }
            });
        });
    </script>
    @stop