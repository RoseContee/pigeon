<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - Admin</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="icon" type="image/png" href="{{ asset('public/'.$setting['favicon']) }}"/>

    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('public/assets/fonts/googlefonts/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/fonts/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/assets/dist/css/adminlte.min.css') }}">

    <!-- Custom CSS -->
    <link href="{{ asset('public/assets/custom/css/admin.css') }}" rel="stylesheet">

    @yield('style')

</head>
<body class="hold-transition login-page">
    <div class="login-box">

        @yield('content')

    </div>
    <!-- /.login-box -->
</body>
</html>
