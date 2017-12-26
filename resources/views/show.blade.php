@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($type as $w)
                @foreach($order as $o)

                    @if($w->tmark == $o->tmark)
                        {{$w->tname}} :{{$o->list}}<br>
                    @endif
                    @endforeach
                @endforeach
        </div>
    </div>
@endsection
