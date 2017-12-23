@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form action="/home" method="post">
            {{ csrf_field() }}
        <div class="col-md-10 col-md-offset-1">
            {{--外层循环 每周菜单--}}
            @foreach($type as $t)
                <div class="panel panel-default" style="">
                <div class="panel-heading" style="text-align:center"><b style="color:red;font-size: large">星期{{$t->tname}}</b></div>
                @foreach($menu as $m)
                    @if($t->tid == $m->mtype)
                    @foreach($shop as $s)
                     <div class="panel-heading" ><span style="color:deepskyblue"></span></div>
                    <div class="panel-heading">餐厅:<input type="radio" name="" value="{{$m->sid}}" > {{$m->sname}}　</div>
                    @if($m->sid == $s->sid)
                    <div class="panel-body">
                        <input type="checkbox" name="" value="">{{$m->fname}} {{$m->price}}元&nbsp;&nbsp;
                    </div>
                    @else
                        <div class="panel-body">
                            暂无
                        </div>
                        @endif
                    @endforeach
                @endif
                @endforeach
                </div>
            @endforeach
                {{--外层循环结束--}}

            <button type="submit" class="btn btn-default">点餐</button>

        </div>
        </form>
    </div>
</div>
@endsection
