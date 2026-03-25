<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - Admin</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('public/'.$setting['favicon']) }}"/>
    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('public/assets/fonts/googlefonts/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/fonts/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/plugins/fontawesome-free/css/all.css') }}" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/toastr/toastr.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/datatables/extensions/Select/css/select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.scss') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/assets/dist/css/adminlte.min.css') }}">

    <!-- Custom CSS -->
    <link href="{{ asset('public/assets/custom/css/admin.css') }}" rel="stylesheet">

    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <div id="loading" class="overlay justify-content-center align-items-center" style="display: none;">
        <i class="fa fa-2x fa-sync fa-spin"></i>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- User profile Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <img src="{{ asset('public/'.$setting['site_logo']) }}" alt="Logo" class="brand-image img-circle elevation-1 mt-0" style="opacity: .8"> <b>Admin</b>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('admin.profile') }}" class="dropdown-item">Profile</a>
                    <a href="{{ route('admin.logout') }}" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin') }}" class="brand-link navbar-light">
            <img src="{{ asset('public/'.$setting['site_logo']) }}" alt="Logo" class="brand-image img-circle elevation-1 mt-0" style="opacity: .8">
            <h3 class="brand-text text-dark m-0">{{ $setting['site_name'] }} <span class="text-warning" style="font-size: 16px">Beta</span></h3>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('admin') }}" class="nav-link @if($menu == 'Dashboard') active @endif">
                            <i class="nav-icon fa fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.platforms') }}" class="nav-link @if($menu == 'Platforms') active @endif">
                            <i class="nav-icon fa fa-thumbs-up"></i>
                            <p>Platforms</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.apps') }}" class="nav-link @if($menu == 'Apps') active @endif">
                            <i class="nav-icon fa fa-smile"></i>
                            <p>Apps</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.words') }}" class="nav-link @if($menu == 'Words') active @endif">
                            <i class="nav-icon fa fa-archive"></i>
                            <p>Words</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.packages') }}" class="nav-link @if($menu == 'Packages') active @endif">
                            <i class="nav-icon fa fa-gift"></i>
                            <p>Membership Packages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.memberships') }}" class="nav-link @if($menu == 'Memberships') active @endif">
                            <i class="nav-icon fa fa-cart-plus"></i>
                            <p>Membership</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users') }}" class="nav-link @if($menu == 'Users') active @endif">
                            <i class="nav-icon fa fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.setting') }}" class="nav-link @if($menu == 'Setting') active @endif">
                            <i class="nav-icon fa fa-tools"></i>
                            <p>Setting</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.profile') }}" class="nav-link @if($menu == 'Profile') active @endif">
                            <i class="nav-icon fa fa-user-circle"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.logout') }}" class="nav-link">
                            <i class="nav-icon fa fa-power-off"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @yield('content')

    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} </strong> All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('public/assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('public/assets/plugins/toastr/toastr.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/assets/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables/extensions/Buttons/js/buttons.html5.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables/extensions/Buttons/js/buttons.print.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables/extensions/Buttons/js/pdfmake.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables/extensions/Buttons/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables/extensions/Select/js/dataTables.select.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js') }}"></script>
<!-- Chart -->
<script src="{{ asset('public/assets/plugins/chart.js/Chart.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/assets/dist/js/adminlte.js') }}"></script>

<!-- Custom -->
<script src="{{ asset('public/assets/custom/js/admin.js') }}"></script>

<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    @if ($info_message = session('info_message'))
        toastr.success('{{ $info_message }}');
    @endif

    @if ($error_message = session('error_message'))
        toastr.error('{{ $error_message }}');
    @endif
</script>

@yield('script')

</body>
</html>
