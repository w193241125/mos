@extends('layouts.app')
@section('css')
    <style type="text/css">
        label {
            cursor: pointer;
            margin-left: 10px;
        }
        .des {
            padding: 0 4px 0 4px
        }
        i {
            color: red;
            padding: 0 4px 0 6px
        }
        .row {
            padding-bottom: 60px;
        }
        .btn {
            float: right
        }
        b {
            color: #007bc1
        }
        .tip {
            position: fixed;
            width: 320px;
            left: 50%;
            top: 40%;
            margin-left: -160px;
            background: #fff;
            border-radius: 6px;
            border: 1px solid #fff;
            box-shadow: 0px 0px 15px 0px #686868;
            z-index: 10000;
            display: none;
        }
        .btn-success {
            position: absolute;
            bottom: -45px;
            right: 0;
        }
        .mes {
            padding: 20px;
        }
        .shade {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            background: rgba(0,0,0,.8);
            display: none;
        }
    </style>
    @show
@section('content')

<div class="container">
    <div class="header">
        <ol class="breadcrumb">
            <li><a href="/home">点餐</a></li>
            <li><a href="/home/show">查询</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="shade">
        </div>
        <div class="tip">
            <div class="mes"></div>
            <div class="btn btn-success">好的</div>
        </div>
        <form action="/home/upd" method="post">
            {{ csrf_field() }}
        <div class="col-md-10 col-md-offset-1">
            {{--外层循环 每周菜单--}}
            @foreach($type as $t)
                <div class="panel panel-default meal" style="">
                <div class="panel-heading" style="text-align:center"><b style="font-size: large">{{$t->tname}}</b></div>
                    @foreach($shop as $s){{--shop--}}
                        @foreach($menu as $m){{--menu--}}
                            @if($t->tmark === $m->tmark && $s->sid === $m->sid){{--同一餐, 同一商店--}}
                                <div class="panel-heading" ><span style="color:deepskyblue"></span></div>
                    <div class="one-option">
                                <div class="panel-heading">
                                    餐厅:<label><input class="dining-room" limit="{{$s->limit_money}}" type="radio" name="shop[{{$t->tmark}}]" value="{{$m->sid}}" >{{$s->sname}} @if($s->sid != 0)　限额:{{$s->limit_money}}元@endif</label>
                                </div>

                                @if($t->tmark == $m->tmark && $s->sid == $m->sid && $m->sid!=0)
                                <div class="panel-body">
                                    @foreach($food as $f)
                                        @if(in_array($f->fid,$m->food)&&$s->sid == $f->sid)
                                            <label>
                                                <input mark="food{{$t->tmark}}" type="checkbox" name="order[{{$t->tmark}}][{{$m->sid}}][{{$f->fid}}]" value="{{$f->price}}">
                                                <span class="des">{{$f->fname}}<i>{{$f->price}}</i> 元</span>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                                @endif
                    </div>
                            @endif
                        @endforeach{{--menu--}}
                    @endforeach{{--shop--}}
                </div>
            @endforeach
                {{--外层循环结束--}}
            <button class="btn btn-default" type="button">点餐</button>
        </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
    <script>
        $(function(){
            // var day = 0,one = 0;
            // var meals = $('.meal').length;
            // for (var i = 0; i < meals; i++) {
            //     var md = $($('.meal')[i]).find('.dining-room');
            //     day = Math.floor(i / 3) + 1;
            //     one = i % 3 + 1;
            //     md.attr('name','shop['+ day +']['+ one +']');
            //
            // }
            // $('.panel-body input:checkbox').attr('disabled', 'disabled')
            // 选择一家餐厅后，其它餐厅菜单不可点击
            $('.dining-room').click(function() {
                var index = $(this).parents('.meal').index();
                var day = Math.floor(index/3) + 1;
                var meal = index % 3;
                if(beforeDay(day,  meal)) {
                    var w = $(this).parents('.one-option').siblings('.one-option');
                    var input = w.find('.panel-body input:checkbox');
                    w.find('input:radio').removeAttr('checked');
                    $(this).attr('checked', 'checked');
                    input.prop('checked', false).removeAttr('checked');
                    $(this).parents('.one-option').find('input:checkbox').attr("disabled",false);
                } else {
                    $(this).prop('checked', false).removeAttr('checked');
                }
            });
            $('.btn-success').click(function() {
                $('.tip').fadeOut();
                $('.shade').fadeOut();
            });
            $('input:checkbox').click(function(event) {
                if($(this).parents('.one-option').find('input:radio').attr('checked') == undefined) {
                    $(this).prop('checked', false);
                    showTip('请选择对应的餐厅');
                }
                else {
                    if($(this).attr('checked') == undefined) {
                        $(this).attr('checked', 'checked');
                    }
                    else {
                        $(this).removeAttr('checked');
                    }
                }
            });
            $('.btn-default').click(function() {
                if(verify()){
                    $(this).attr('type', 'submit')
                };
            })
        })

        function verify() {
            var total = 0//中晚餐总价
            var arr = [];
            var din = $('.dining-room')
            din.each(function(i) {
                if($(this).attr('checked') == 'checked'){
                    var maxPrice = parseInt($(this).attr('limit'));
                    console.log(maxPrice)
                    var text = $(this).parents('.meal').find('b').text();
                    var menu = $(this).parents('.one-option').find('input:checkbox');
                    menu.each(function() {
                        var price = parseInt($(this).next().find('i').text());
                        if($(this).attr('checked') == 'checked') {
                            total += price;
                        }
                    });
                    if(total > maxPrice) {
                        arr.push(text);
                    }
                }
                total = 0;
            });
            if(arr.length == 0) {
                return true
            } else {
                var str = '';
                var lStr = ''
                arr.forEach(function(item) {
                    str += '<li>' + item + '</li>'
                });
                lStr = '<p>以下菜单超出限额,请您重新下单!!</p><ul>' + str + '</ul>';
                showTip(lStr);
            }
        }
        function showTip(message) {
            $('.mes').html(message);
            $('.shade').fadeIn();
            $('.tip').fadeIn();
            return;
        }
        function beforeDay(day, index) {
            var start = new Date();
            var errand = start.getDay() - day;
            var startTime = [0, 0, 0, 0];
            setTime(start, startTime);
            var todayStartTime = Date.parse(start);
            var clcikTime = Date.now() - errand * 86400 * 1000;
            if(clcikTime < todayStartTime) {
                showTip('所选时间已经是过去式啦, 不能再下单了！！');
                return false;
            } else {
                var plus = (errand < 0 ? - errand : 0) * 86400 * 1000;
                var morning = new Date(),
                    mid = new Date(),
                    dinner = new Date();
                var morningTime = [7, 0, 0, 0], midTime = [10, 30, 0, 0], dinnerTime = [16, 0, 0, 0];
                if(index == 0) {
                    var mt = Date.parse(setTime(morning, morningTime)) + plus
                    if(Date.now() > mt) {
                        showTip('早餐请在7:00之前下单哦！！');
                        return false;
                    }
                } else if (index == 1) {
                    var midT = Date.parse(setTime(mid, midTime)) + plus
                    if(Date.now() > midT) {
                        showTip('中餐请在10:30之前下单哦！！');
                        return false;
                    }
                } else if (index == 2) {
                    var dinnerT = Date.parse(setTime(dinner, dinnerTime)) + plus;
                    if(Date.now() > dinnerT) {
                        showTip('晚餐请在16:00之前下单哦！！');
                        return false;
                    }
                }
                return true
            }
        }
        function setTime(object, time) {
            object.setHours(time[0]);
            object.setMinutes(time[1]);
            object.setSeconds(time[2]);
            object.setMilliseconds(time[3] ? time[3] : 0);
            return object;
        }
    </script>
    @stop