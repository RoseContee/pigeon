@extends('user.auth.layout')

@section('title', 'Not found')

@section('content')
    <div class="login-logo">
        <img src="{{ asset('public/'.$setting['site_logo']) }}" alt="LOGO">
        <b>{{ $setting['site_name'] }}</b>
    </div>
    @if (!empty($error_message))
        <div class="alert text-danger text-center">
            {!! $error_message !!}
        </div>
    @endif
    @if (!empty($info_message))
        <div class="alert text-info text-center">
            {!! $info_message !!}
        </div>
    @endif
    <div class="col-12 text-center">
        @if (Auth::check())
            <a href="{{ route('home') }}" class="btn btn-primary btn-flat">Go to home</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-danger btn-flat">Back to login</a>
        @endif
    </div>
@endsection

@section('style')
    <style type="text/css">
        .login-box {
            width: auto;
        }
    </style>
@endsection