@extends('layouts.app')
@section('css')
    <style type="text/css">
        .price {
            float: right;
            margin-left: 10px;
        }
        label {
            cursor: pointer;
            margin-left: 10px;
        }
        .des {
            padding: 0 4px 0 4px;
            color: #0a689d;
            font-size: 15px;
        }
        i {
            color: red;
            padding: 0 4px 0 6px
        }
        .row {
            padding-bottom: 60px;
        }
        .btn {
            float: right;
            position:fixed;
            bottom:10px;
            right: 17%;
        }
        /*屏幕宽度不大于500时提交按钮显示位置*/
        @media screen and (max-width: 500px) {
            .btn {float: right;position:fixed;bottom:5px;right: 5%;}
        }
        /*屏幕宽度不小于700时提交按钮显示位置*/
        @media screen and (min-width: 700px) {
            .btn {float: right;position:fixed;bottom:5px;right: 5%;}
        }

        /* 屏幕宽度不小于1440时提交按钮显示位置*/
        @media screen and (min-width: 1440px) {
            .btn {float: right;position:fixed;bottom:10px;right: 17%;}
        }

        /* 屏幕宽度不小于1900时提交按钮显示位置*/
        @media screen and (min-width: 1900px) {
            .btn {float: right;position:fixed;bottom:10px;right: 22%;}
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
        /*屏幕宽度不大于500时提交按钮显示位置*/
        @media screen and (max-width: 500px) {
            .elevator_list{
                position: fixed;
                right: 2%;
                top:40%;
                background-color: #f6f9fa;
                border: 1px solid #e5e9ef;
                overflow: hidden;
                border-radius: 4px;
                width: 50px;
                height: 196px;
                z-index: 999;
            }
        }
        /* 屏幕宽度不da于1023时提交按钮显示位置*/
        @media screen and (max-width: 1023px) {
            .elevator_list{
                position: fixed;right: 5%;top:40%;background-color: #f6f9fa;border: 1px solid #e5e9ef;overflow: hidden;border-radius: 4px;width: 50px;height: 196px;z-index: 999;
            }
        }

        /* 屏幕宽度不小于1023时提交按钮显示位置*/
        @media screen and (min-width: 1023px) {
            .elevator_list{
                position: fixed;right: 5%;top:40%;background-color: #f6f9fa;border: 1px solid #e5e9ef;overflow: hidden;border-radius: 4px;width: 50px;height: 196px;z-index: 999;
            }
        }

        /* 屏幕宽度不小于1900时提交按钮显示位置*/
        @media screen and (min-width: 1900px) {
            .elevator_list{
                position: fixed;right: 20%;top:40%;background-color: #f6f9fa;border: 1px solid #e5e9ef;overflow: hidden;border-radius: 4px;width: 50px;height: 196px;z-index: 999;
            }
        }

        .elevator{
            background-color: #f6f9fa;border-radius: 10px;text-align: center;line-height:32px;width: 48px;height: 32px;
        }
        .elevator:hover{
            cursor: pointer;
            background-color: #9acfea;
        }
    </style>
    @show
@section('content')

<div class="container">
    <div class="header">
        <ol class="breadcrumb">
            <li><a href="/" >本周点餐</a></li>
            <li><a href="/home/show">查询</a></li>
            @if($dayWeek==5||$dayWeek==6||$dayWeek==7||$dayWeek==0)
                <li><a href="/nextweek" >下周点餐</a></li>
                <li><a href="/home/showNextWeek">查询下周</a></li>
            @endif
        </ol>
    </div>
    @if(Auth::user()->state != 4)
        <div class="elevator_list">
            <a href="#A"><div class="elevator">一</div></a>
            <a href="#D"><div class="elevator">二</div></a>
            <a href="#G"><div class="elevator">三</div></a>
            <a href="#J"><div class="elevator">四</div></a>
            <a href="#M"><div class="elevator">五</div></a>
            <a href="#P"><div class="elevator">六</div></a>
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
                    <div class="panel panel-default meal" style="" >
                        <div class="panel-heading" style="text-align:center"><a name="{{$t->tmark}}"></a><b style="font-size: large">{{$t->tname}}</b></div>
                        @foreach($shop as $s){{--shop--}}
                        @foreach($menu as $m){{--menu--}}
                        @if($t->tmark === $m->tmark && $s->sid === $m->sid){{--同一餐, 同一商店--}}
                        <div class="panel-heading" >
                            <span style="color:red;font-weight:700;">@if($s->sid==2)请注意城市简餐的米饭现在要点了才有!!!!@endif</span>
                        </div>
                        <div class="one-option">
                            <div class="panel-heading">
                                餐厅:<label><input class="dining-room" limit="{{$s->limit_money}}" type="radio" name="shop[{{$t->tmark}}]" value="{{$m->sid}}" tweek="{{$t->tweek}}"><span>{{$s->sname}}</span> @if($s->sid != 0)　限额:{{$s->limit_money}}元 @endif <div class="price"></div></label>
                            </div>

                            @if($t->tmark == $m->tmark && $s->sid == $m->sid && $m->sid!=0) {{--菜单时间在时间分类里面,菜单商家在商家表里面,商家不是测试商家--}}
                                <div class="panel-body">
                                    @foreach($food as $f)
                                        @if(in_array($f->fid,$m->food)&&$s->sid == $f->sid){{--食物再食物列表,食物商家在商家表--}}
                                            <label>
                                                <input mark="food{{$t->tmark}}" type="checkbox" name="order[{{$t->tmark}}][{{$m->sid}}][{{$f->fid}}]" value="{{$f->price}}" ftype="{{$f->ftype}}">
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
                {{--@endif--}}
            @endforeach
                {{--外层循环结束--}}
            <button class="btn btn-default" type="submit" style="font-weight: bold;color:red;">提交</button>
        </div>
        </form>
    </div>
        @endif
</div>
<div id="time_limited">
    @foreach($timelimited as $tl)
        <span id="time_limited_{{$tl->time_mark}}" timelimited="{{$tl->time_limited}}"></span>
    @endforeach
</div>

@endsection
@section('scripts')
    <script>
        $(function(){
            // $('.panel-body input:checkbox').attr('disabled', 'disabled')
            // 选择一家餐厅后，其它餐厅菜单不可点击
            $('.dining-room').click(function() {
                var index = $(this).parents('.meal').index();
//                var day = Math.floor(index/3) + 1;
                var day = $(this).attr('tweek');
                var meal = index % 3;
                if(beforeDay(day,  meal)) {
                    var w = $(this).parents('.one-option').siblings('.one-option');
                    var input = w.find('.panel-body input:checkbox');
                    w.find('input:radio').removeAttr('checked');
                    $(this).attr('checked', 'checked');
                    input.prop('checked', false).removeAttr('checked');
                    $(this).parents('.one-option').find('input:checkbox').attr("disabled",false);
                    w.find('input:radio').siblings('.price').html('')

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
                    var calPrice = 0;
                    var check = $(this).parents('.panel-body').find('input:checkbox');
                    if($(this).attr('checked') == undefined) {
                        $(this).attr('checked', 'checked');
                    }
                    else {
                        $(this).removeAttr('checked');
                    }
                    check.each(function(index, item) {
                        if($(item).attr('checked') == 'checked') {
                            calPrice += parseFloat($(item).attr('value'));
                        }
                    });
                    var getLimit = parseFloat($(this).parents('.panel-body').siblings().find('input:radio').attr('limit'));
                    $(this).parents('.panel-body').siblings().find('.price').html(calPrice <= getLimit ? calPrice + '元' : calPrice + '元(超额)')
                    if(calPrice > getLimit) {
                        $(this).parents('.panel-body').siblings().find('.price').css({'color': 'red'});
                    } else {
                        $(this).parents('.panel-body').siblings().find('.price').css({'color': '#3c96d5'});
                    }

                }
            });
            $('.btn-default').click(function(e) {
                if(!verifyDrink()){
                    e.preventDefault();
                }
                if(!verify()){
                    e.preventDefault();
                }
            })
        });

        function verify() {
            var total = 0 //中晚餐总价
            var arr = [];
            var din = $('.dining-room')
            din.each(function(i) {
                if($(this).attr('checked') == 'checked'){
                    var maxPrice = parseFloat($(this).attr('limit'));
                    var text = $(this).parents('.meal').find('b').text(); //获取 星期* 早上、中午、晚上
                    var menu = $(this).parents('.one-option').find('input:checkbox');
                    menu.each(function() {
                        var price = parseFloat($(this).next().find('i').text());
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
        function verifyDrink() {
            var total = 0; //饮料总数
            var arr = [];
            var din = $('.dining-room'); //获取当前点的哪一餐
            din.each(function(i) {
                if($(this).attr('checked') == 'checked'){
                    var maxDrink = {{$max_drink}};//最多点多少瓶饮料
                    var text = $(this).parents('.meal').find('b').text();//获取 星期* 早上、中午、晚上
                    var menu = $(this).parents('.one-option').find('input:checkbox');
                    menu.each(function() {
                        var ftype = $(this).attr('ftype');
                        if (ftype == 3 && $(this).attr('checked') == 'checked'){
                            total ++;
                        }
                    });
                    if(total > maxDrink) {
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
                lStr = '<p>以下菜单饮料点多了,每餐只能点{{$max_drink}}瓶,请您重新下单!!</p><ul>' + str + '</ul>';
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
            var today = start.getDay();
            if(today == 0) today = 7;
            var errand = today - day;
            var now = Date.now()
            if(errand > 0) {
                showTip('不能选择今天之前的餐厅哦！！');
                return false;
            } else {
                var morning = new Date(),
                    mid = new Date(),
                    dinner = new Date();
                //07:00:00
                var morningTime = $('#time_limited_1').attr('timelimited'), midTime = $('#time_limited_2').attr('timelimited'), dinnerTime = $('#time_limited_3').attr('timelimited');
                if(errand == 0) {
                    if(index == 0) {
                        var mt = Date.parse(setTime(morning, morningTime))
                        if(now > mt) {
                            showTip('早餐请在'+morningTime+'之前下单哦！！');
                            return false;
                        }
                    } else if (index == 1) {
                        var midT = Date.parse(setTime(mid, midTime));
                        if(now > midT) {
                            showTip('中餐请在'+midTime+'之前下单哦！！');
                            return false;
                        }
                    } else if (index == 2) {
                        var dinnerT = Date.parse(setTime(dinner, dinnerTime))
                        if(now > dinnerT) {
                            showTip('晚餐请在'+dinnerTime+'之前下单哦！！');
                            return false;
                        }
                    }
                }
                return true
            }
        }
        function setTime(object, time) {
            var times = time.split(':');
            object.setHours(times[0]);
            object.setMinutes(times[1]);
            object.setSeconds(times[2]?times[2]:0);
            object.setMilliseconds(times[3] ? times[3] : 0);
            return object;
        }
    </script>
    @stop