@extends('user.auth.layout')

@section('title', 'Forgot password')

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
            <h4 class="login-box-msg">Reset your password</h4>
            <p class="login-box-msg">Enter your account email address so we can reset your password.</p>

            <form action="{{ route('admin.forgot-password') }}" method="post">
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
                <div class="input-group mb-3 @if ($errors->has('email')) has-error @endif">
                    <input type="text" name="email" class="form-control" placeholder="Email"
                           value="{{ old('email') }}" required>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-envelope"></span>
                    </div>
                    @if ($errors->has('email'))<span class="w-100 ml-2 small error">{{ $errors->first('email') }}</span>@endif
                </div>
                <div class="row">
                    <div class="col-4">
                        <a href="{{ route('admin.login') }}" class="btn btn-danger btn-block btn-flat">Back</a>
                    </div>
                    <div class="col-4"></div>
                    <!-- /.col -->
                    <div class="col-4 text-right">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Next</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection