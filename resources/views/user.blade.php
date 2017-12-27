@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('resetMsg') == 1)
            <div class="alert alert-success">
                <strong> 操作成功!</strong>
            </div>
        @elseif(session('resetMsg') == 2)
            <div class="alert alert-danger">
                <strong>操作失败!</strong>
            </div>
        @endif
        <div class="row">
            <form class="form-horizontal" method="POST" action="user/reset">
                {{ csrf_field() }}
                <input type="hidden" name="uid" value="{{Auth::user()->uid}}">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="old_pass" class="col-md-4 control-label">老密码</label>

                    <div class="col-md-6">
                        <input id="old_pass" type="password" class="form-control" name="old_pass"  required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-4 control-label">新密码</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required >

                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 control-label">确认密码</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required min="6">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            确认修改
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
