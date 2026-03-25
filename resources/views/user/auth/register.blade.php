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
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection