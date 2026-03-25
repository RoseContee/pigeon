@extends('user.auth.layout')

@section('title', 'Log in')

@section('content')
    <div class="login-logo">
        <a href="{{ route('index') }}">
            <img src="{{ asset('public/'.$setting['site_logo']) }}" alt="LOGO">
            <b>{{ $setting['site_name'] }}</b>
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <h4 class="login-box-msg">Welcome Back</h4>
            <div class="social-auth-links text-center mb-3">
                <a href="{{ route('auth-google') }}" class="btn btn-block btn-flat p-0">
                    <img src="{{ asset('public/assets/images/google/google_signin_normal.png') }}" class="btn-google-normal w-100">
                    <img src="{{ asset('public/assets/images/google/google_signin_focus.png') }}" class="btn-google-hover w-100">
                    <img src="{{ asset('public/assets/images/google/google_signin_pressed.png') }}" class="btn-google-focus w-100">
                </a>
                {{--<a href="{{ route('auth-linkedin') }}" class="btn btn-primary btn-block btn-flat">--}}
                    {{--<i class="fa fa-linkedin mr-2"></i> Sign in using LinkedIn--}}
                {{--</a>--}}
                {{--<p class="my-2">---------- OR ----------</p>--}}
            </div>
            {{--<form action="{{ route('login') }}" method="post">
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
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-envelope"></span>
                    </div>
                    @if ($errors->has('email'))<span class="w-100 ml-2 small error">{{ $errors->first('email') }}</span>@endif
                </div>
                <div class="input-group mb-3 @if ($errors->has('password')) has-error @endif">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-lock"></span>
                    </div>
                    @if ($errors->has('password'))<span class="w-100 ml-2 small error">{{ $errors->first('password') }}</span>@endif
                </div>
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <a href="{{ route('forgot-password') }}">Forgot Password?</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr class="w-100">
                    </div>
                    <div class="col-12 text-center">
                        Don't have an account? <a href="{{ route('signup') }}">Sign Up</a>
                    </div>
                </div>
            </form>--}}
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection

@section('script')
    <script type="text/javascript">
    </script>
@endsection