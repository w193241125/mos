@extends('layouts.app')
@section('titles')
    技术部
@endsection
@section('content')
    <div class="container">
        <div class="header">
            <ol class="breadcrumb">
                <li><a href="/home">点餐</a></li>
                <li><a href="/home/show">查询</a></li>
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
                                    {{$o->uname}}.{{$name[$o->uname]}}: {{$o->food}}<br>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="row">

        </div>
    </div>
@endsection
