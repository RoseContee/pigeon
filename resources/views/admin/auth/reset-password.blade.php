@extends('user.auth.layout')

@section('title', 'Reset your password')

@section('content')
    <div class="login-logo">
        <a href="{{ route('admin') }}">
            <img src="{{ asset('public/'.$setting['site_logo']) }}" alt="LOGO">
            <b class="text-uppercase">{{ $setting['site_name'] }}</b>
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <h4 class="login-box-msg">Enter your new password.</h4>

            <form action="{{ url()->current() }}" method="post">
                @csrf
                @if (session('info_message'))
                    <div class="alert alert-info">
                        {{ session('info_message') }}
                    </div>
                @endif
                @if (session('error_message'))
                    <div class="alert alert-danger">
                        {{ session('error_message') }}
                    </div>
                @endif
                <div class="input-group mb-3 @if ($errors->has('password')) has-error @endif">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-lock"></span>
                    </div>
                    @if ($errors->has('password'))<span class="w-100 ml-2 small error">{{ $errors->first('password') }}</span>@endif
                </div>
                <div class="input-group mb-3 @if ($errors->has('password_confirmation')) has-error @endif">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-lock"></span>
                    </div>
                    @if ($errors->has('password_confirmation'))<span class="w-100 ml-2 small error">{{ $errors->first('password_confirmation') }}</span>@endif
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection