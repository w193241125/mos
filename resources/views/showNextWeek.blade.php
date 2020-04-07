@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('message'))
            <div class="alert alert-success">
                <strong> {{session('message')}}!</strong>
            </div>
        @elseif(session('error_msg'))
            <div class="alert alert-danger">
                <strong>{{session('error_msg')}}!</strong>
            </div>
        @endif
        <div class="header">
            <ol class="breadcrumb">
                <li><a href="/nextweek" >下周点餐</a></li>
                <li><a href="/home/showNextWeek">查询下周</a></li>
            </ol>
        </div>
        <div class="bs-example" data-example-id="bordered-table">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>时间</th>
                    <th>点餐</th>
                </tr>
                </thead>
                <tbody>
                @foreach($type as $t)
                    <tr>
                        <td>
                            {{$t->tname}}
                        </td>

                        <td>
                            @foreach($order as $o)
                                @if($t->tmark == $o->tmark)
                                    {{$o->food}}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="row">
            {{--@foreach($type as $t)--}}
                {{--@foreach($order as $o)--}}

                    {{--@if($t->tmark == $o->tmark)--}}
                        {{--{{$t->tname}} :{{$o->food}}<br>--}}
                    {{--@endif--}}
                    {{--@endforeach--}}
                {{--@endforeach--}}
        </div>
    </div>
@endsection
