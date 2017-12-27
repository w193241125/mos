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
                    @foreach($shop as $s){{--shop--}}
                    @foreach($menu as $m){{--menu--}}
                        @if($t->tmark == $m->tmark && $s->sid == $m->sid){{--同一餐, 同一商店--}}
                            <div class="panel-heading" ><span style="color:deepskyblue"></span></div>
                            <div class="panel-heading">餐厅:<input type="radio" name="shop{{$t->tmark}}" value="{{$m->sid}}" > {{$s->sname}}　</div>

                        @if($t->tmark == $m->tmark && $s->sid == $m->sid)
                        <div class="panel-body">
                            @foreach($food as $f)
                            @if(in_array($f->fid,$m->food)&&$s->sid == $f->sid)
                                <input type="checkbox" name="order[{{$t->tmark}}][{{$m->sid}}][{{$f->fid}}]" value="{{$f->price}}">{{$f->fname}} {{$f->price}}元&nbsp;&nbsp;
                            @endif
                            @endforeach
                        </div>
                        @endif
                        @endif
                    @endforeach{{--menu--}}
                    @endforeach{{--shop--}}
                </div>
            @endforeach
                {{--外层循环结束--}}
            <button type="submit" class="btn btn-default">点餐</button>
        </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
    <script>

    </script>
    @stop