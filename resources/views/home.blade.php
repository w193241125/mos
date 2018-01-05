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
            <li><a href="/" >本周点餐</a></li>
            <li><a href="/home/show">查询</a></li>
            @if($dayWeek==5)
                <li><a href="/nextweek" >下周点餐</a></li>
                <li><a href="/home/showNextWeek">查询下周</a></li>
            @endif
        </ol>
    </div>
    @if(Auth::user()->state != 4)
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
                @if($t->tmark=='P'||$t->tmark=='Q'||$t->tmark=='R')
                    @if($fmods==1)
                <div class="panel panel-default meal" style="">
                <div class="panel-heading" style="text-align:center"><b style="font-size: large">{{$t->tname}}</b></div>
                    @foreach($shop as $s){{--shop--}}
                        @foreach($menu as $m){{--menu--}}
                            @if($t->tmark === $m->tmark && $s->sid === $m->sid){{--同一餐, 同一商店--}}
                                <div class="panel-heading" ><span style="color:deepskyblue"></span></div>
                    <div class="one-option">
                                <div class="panel-heading">
                                    餐厅:<label><input class="dining-room" limit="{{$s->limit_money}}" type="radio" name="shop[{{$t->tmark}}]" value="{{$m->sid}}" ><span>{{$s->sname}}</span> @if($s->sid != 0)　限额:{{$s->limit_money}}元@endif <div class="price"></div></label>
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
                        @endif
                @else
                    <div class="panel panel-default meal" style="">
                        <div class="panel-heading" style="text-align:center"><b style="font-size: large">{{$t->tname}}</b></div>
                        @foreach($shop as $s){{--shop--}}
                        @foreach($menu as $m){{--menu--}}
                        @if($t->tmark === $m->tmark && $s->sid === $m->sid){{--同一餐, 同一商店--}}
                        <div class="panel-heading" ><span style="color:deepskyblue"></span></div>
                        <div class="one-option">
                            <div class="panel-heading">
                                餐厅:<label><input class="dining-room" limit="{{$s->limit_money}}" type="radio" name="shop[{{$t->tmark}}]" value="{{$m->sid}}" ><span>{{$s->sname}}</span> @if($s->sid != 0)　限额:{{$s->limit_money}}元@endif <div class="price"></div></label>
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
                @endif
            @endforeach
                {{--外层循环结束--}}
            <button class="btn btn-default" type="submit">点餐</button>
        </div>
        </form>
    </div>
        @endif
</div>

@endsection
@section('scripts')
    <script>
        $(function(){
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
                if(!verify()){
                    e.preventDefault();
                }
            })
        });

        function verify() {
            var total = 0//中晚餐总价
            var arr = [];
            var din = $('.dining-room')
            din.each(function(i) {
                if($(this).attr('checked') == 'checked'){
                    var maxPrice = parseFloat($(this).attr('limit'));
                    var text = $(this).parents('.meal').find('b').text();
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
        function showTip(message) {
            $('.mes').html(message);
            $('.shade').fadeIn();
            $('.tip').fadeIn();
            return;
        }
        function beforeDay(day, index) {
            var start = new Date();
            var errand = start.getDay() - day;
            var now = Date.now()
            if(errand > 0) {
                showTip('不能选择今天之前的餐厅哦！！');
                return false;
            } else {
                var morning = new Date(),
                    mid = new Date(),
                    dinner = new Date();
                var morningTime = [7, 0, 0, 0], midTime = [10, 30, 0, 0], dinnerTime = [16, 0, 0, 0];
                if(errand == 0) {
                    if(index == 0) {
                        var mt = Date.parse(setTime(morning, morningTime))
                        if(now > mt) {
                            showTip('早餐请在7:00之前下单哦！！');
                            return false;
                        }
                    } else if (index == 1) {
                        var midT = Date.parse(setTime(mid, midTime));
                        if(now > midT) {
                            showTip('中餐请在10:30之前下单哦！！');
                            return false;
                        }
                    } else if (index == 2) {
                        var dinnerT = Date.parse(setTime(dinner, dinnerTime))
                        if(now > dinnerT) {
                            showTip('晚餐请在16:00之前下单哦！！');
                            return false;
                        }
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