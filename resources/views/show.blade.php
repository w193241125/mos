@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="header">
            <ol class="breadcrumb">
                <li><a href="/home">点餐</a></li>
                <li><a href="/home/show">查询</a></li>
            </ol>
        </div>

        <div class="row">
            @foreach($type as $t)
                @foreach($order as $o)

                    @if($t->tmark == $o->tmark)
                        {{$t->tname}} :{{$o->food}}<br>
                    @endif
                    @endforeach
                @endforeach
        </div>
    </div>
@endsection
