@extends('user.auth.layout')

@section('title', 'User Register')

@section('content')
    <div class="login-logo">
        <a href="{{ route('index') }}">
            <img src="{{ asset('public/'.$setting['site_logo']) }}" alt="LOGO">
            <b>{{ $setting['site_name'] }}</b>
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body register-card-body">
            <h4 class="login-box-msg">Sign Up</h4>
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
            {{--<form action="{{ route('signup') }}" method="post">
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
                <div class="input-group mb-3 @if ($errors->has('name')) has-error @endif">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-user"></span>
                    </div>
                    @if ($errors->has('name'))<span class="w-100 ml-2 small error">{{ $errors->first('name') }}</span>@endif
                </div>
                <div class="input-group mb-3 @if ($errors->has('email')) has-error @endif">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-envelope"></span>
                    </div>
                    @if ($errors->has('email'))<span class="w-100 ml-2 small error">{{ $errors->first('email') }}</span>@endif
                </div>
                <div class="input-group mb-3 @if ($errors->has('password')) has-error @endif">
                    <input type="password" name="password" class="form-control" placeholder="Password" minlength="6" required>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-lock"></span>
                    </div>
                    @if ($errors->has('password'))<span class="w-100 ml-2 small error">{{ $errors->first('password') }}</span>@endif
                </div>
                <div class="input-group mb-3 @if ($errors->has('password_confirmation')) has-error @endif">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" minlength="6" required>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-lock"></span>
                    </div>
                    @if ($errors->has('password_confirmation'))<span class="w-100 ml-2 small error">{{ $errors->first('password_confirmation') }}</span>@endif
                </div>
                <div class="row">
                    <div class="col-12 mb-2">
                        <input type="checkbox" id="agreeTerms" name="terms" value="agree" checked required>
                        <label for="agreeTerms" class="font-weight-normal text-dark mb-0">
                            I agree to the <a href="{{ route('terms') }}" target="_blank">Terms of Use</a> & <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>
                        </label>
                        @if ($errors->has('terms'))<div class="w-100 ml-2 small error">{{ $errors->first('terms') }}</div>@endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Join Us</button>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-12">
                        <hr class="w-100">
                    </div>
                    <div class="col-12 text-center">
                        Already have an account? <a href="{{ route('login') }}">Sign In</a>
                    </div>
                </div>
            </form>--}}
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection