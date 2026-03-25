<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - {{ $setting['site_name'] }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('seo')

    <link rel="icon" type="image/png" href="{{ asset('public/'.$setting['favicon']) }}"/>
    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('public/assets/fonts/googlefonts/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/fonts/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/assets/dist/css/adminlte.min.css') }}">

    <!-- Custom CSS -->
    <link href="{{ asset('public/assets/custom/css/style.css') }}" rel="stylesheet">
    <style type="text/css">
        body {
            background-color: #f2f1f1;
        }

        .btn {
            border-radius: .5rem;
        }

        .card {
            height: calc(100% - 1rem);
            border-radius: 1rem;
        }
    </style>

    @yield('style')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179172738-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-179172738-1');
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PTM9D5T');
    </script>
    <!-- End Google Tag Manager -->
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTM9D5T"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="wrapper">
    <div class="container">
        <nav class="navbar navbar-expand">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('public/'.$setting['site_logo']) }}" alt="Logo" class="home-logo img-circle elevation-1 mt-0">
                        <span class="text-warning ml-1">Beta</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="btn btn-primary btn-regal-blue text-white" href="{{ route('home') }}">Account</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-primary bg-regal-blue text-white" href="#" data-toggle="modal" data-target="#login-modal">Sign in for free</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

    @yield('content')
</div>

<div class="bg-footer py-5">
    <div class="container text-center">
        <div class="py-2"></div>
        <div class="row">
            <div class="col-12">
                <h1 class="h1">
                    <a @if (!Auth::check()) href="#" data-toggle="modal" data-target="#login-modal"
                       @else href="https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm" target="_blank" @endif
                    class="text-white">Join {{ $setting['site_name'] }} today!</a>
                </h1>
                <h3 class="h3 font-weight-light text-white">Do more, before & after meetings</h3>
            </div>
            <div class="col-12 py-3">
                <a href="https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm" target="_blank" class="btn btn-primary bg-regal-blue">Add to Chrome - It's free</a>
            </div>
        </div>
    </div>
</div>

<footer class="text-white-50 py-4">
    <div class="container text-center text-sm-left">
        <div class="float-sm-right d-sm-inline-block mb-3 mb-sm-0">
            <a href="{{ route('privacy') }}" class="text-white-50 mr-5">Privacy Policy</a> <a href="{{ route('terms') }}" class="text-white-50">Terms of Use</a>
        </div>
        <strong>&copy; </strong> 2020 <span class="text-capitalize">{{ $setting['site_name'] }}</span> Labs
        <a href="{{ $setting['facebook_link'] }}" class="text-white-50 px-1 ml-4"><i class="fa fa-facebook"></i></a>
        <a href="{{ $setting['twitter_link'] }}" class="text-white-50 px-1 ml-4"><i class="fa fa-twitter"></i></a>
        <a href="{{ $setting['linkedin_link'] }}" class="text-white-50 px-1 ml-4"><i class="fa fa-linkedin"></i></a>
    </div>
</footer>

@if (!Auth::check())
    <!-- Login Modal -->
    <div class="modal fade" id="login-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Login with your google account</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8 offset-2">
                            <div class="social-auth-links text-center mb-3">
                                <a href="{{ route('auth-google') }}" class="btn btn-block btn-flat p-0">
                                    <img src="{{ asset('public/assets/images/google/google_signin_normal.png') }}" class="btn-google-normal w-100">
                                    <img src="{{ asset('public/assets/images/google/google_signin_focus.png') }}" class="btn-google-hover w-100">
                                    <img src="{{ asset('public/assets/images/google/google_signin_pressed.png') }}" class="btn-google-focus w-100">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endif

<!-- jQuery -->
<script src="{{ asset('public/assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@yield('script')

</body>
</html>