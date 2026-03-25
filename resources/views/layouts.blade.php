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
    <!-- Date picker -->
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/toastr/toastr.min.css') }}">
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
                    {{--<li class="nav-item">
                        <a class="btn btn-primary bg-regal-blue text-white" href="#" data-toggle="modal" data-target="#login-modal">Sign in for free</a>
                    </li>--}}
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

<footer class="text-white-50 text-center py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <a href="{{ route('support') }}" class="text-white-50 mr-3 mr-sm-5">Get Support</a>
                <a href="{{ route('knowledgebase') }}" class="text-white-50 mr-3 mr-sm-5">Knowledge Base</a>
                <a href="{{ route('faq') }}" class="text-white-50 mr-0 mr-md-5">FAQ</a>
                <br class="d-sm-block d-md-none">
                <a href="{{ route('privacy') }}" class="text-white-50 mr-5">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="text-white-50">Terms of Use</a>
            </div>
            <div class="col-12">
                <strong>&copy; </strong> 2020 <span class="text-capitalize">{{ $setting['site_name'] }}</span> Labs
                <a href="{{ $setting['facebook_link'] }}" class="text-white-50 px-1 ml-2 ml-md-4"><i class="fa fa-facebook"></i></a>
                <a href="{{ $setting['twitter_link'] }}" class="text-white-50 px-1 ml-2 ml-md-4"><i class="fa fa-twitter"></i></a>
                <a href="{{ $setting['linkedin_link'] }}" class="text-white-50 px-1 ml-2 ml-md-4"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
    </div>
</footer>

@if (empty($_COOKIE['cookies-policy']))
    <div id="cookies-policy" style="display: none;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    Pigeon uses cookies to understand your event preferences and make sure you have the best experience on our site.
                    By using this platform, you accept our use of <a href="{{ route('cookies-policy') }}">cookies</a>.
                </div>
                <div class="col-12 text-center mt-2">
                    <button id="accept-cookies" class="btn btn-success btn-flat py-0 mr-3">Accept</button>
                    <button id="decline-cookies" class="btn btn-default btn-flat py-0">Decline</button>
                </div>
            </div>
        </div>
    </div>
@endif

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
<!-- InputMask -->
<script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
<!-- date picker -->
<script src="{{ asset('public/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('public/assets/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
    $(function() {
        @if (empty($_COOKIE['cookies-policy']))
            setTimeout(function() {
                $('#cookies-policy').show();
            }, 1500);

            $('#accept-cookies').on('click', function() {
                $('#cookies-policy').hide();
                document.cookie = "cookies-policy=true; expires=Thu, 31 Dec " + (new Date().getFullYear() + 100) + " 12:00:00 UTC";
            });

            $('#decline-cookies').on('click', function() {
                location.href = "{{ route('cookies-policy') }}";
            });
        @endif

        @if (!Auth::check() && !empty($where) && $where == 'extension')
            $('#login-modal').modal('show');
        @endif

        @if ($info_message = session('info_message'))
            toastr.success('{{ $info_message }}');
        @endif

        @if ($error_message = session('error_message'))
            toastr.error('{{ $error_message }}');
        @endif
    });
</script>

@yield('script')

</body>
</html>