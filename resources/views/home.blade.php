@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form action="/home" method="post">
            {{ csrf_field() }}
        <div class="col-md-10 col-md-offset-1">
            {{--外层循环 每周菜单--}}
                @foreach($week as $w)
                <div class="panel panel-default" style="">
                <div class="panel-heading" style="text-align:center"><b style="color:red;font-size: large">星期{{$w->mweek}}</b></div>
                {{--循环每日菜单--}}
                @foreach($menu as $a)
                @if($w->mweek==$a->mweek)
                <div class="panel-heading" ><span style="color:deepskyblue">@if($a->mtype==1) 早餐@elseif($a->mtype==2)中餐@elseif($a->mtype==3)晚餐 @elseif($a->mtype==4)下午茶@endif </span></div>
                <div class="panel-heading">餐厅:　<input type="radio" name="{{$a->week_mark}}{{$a->day_mark}}[shop]" value="1">{{$a->sname}}</div>

                <div class="panel-body">
                    {{--{{dd($menu)}}--}}
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($menu->where('sid',1) as $m)
                        <input type="checkbox" name="{{$a->week_mark}}{{$a->day_mark}}[]" value="{{$m->fid}}">{{$m->fname}}&nbsp;{{$m->price}}元&nbsp;&nbsp;
                    @endforeach
                </div>
                @endif
                @endforeach
                {{--循环每日菜单--}}

            </div>
                @endforeach
            {{--外层循环结束--}}

            <button type="submit" class="btn btn-default">Submit</button>

        </div>
        </form>
    </div>
</div>
@endsection
