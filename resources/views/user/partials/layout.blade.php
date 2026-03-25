<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - {{ $setting['site_name'] }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="keywords" content="{{ $setting['meta_keywords'] }}"/>
    <meta name="description" content="{{ $setting['meta_description'] }}"/>

    <meta property="og:title" content="{{ $setting['meta_title'] }}"/>
    <meta property="og:url" content="{{ $setting['site_url'] }}"/>
    <meta property="og:description" content="{{ $setting['meta_description'] }}"/>

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
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/assets/dist/css/adminlte.min.css') }}">

    <!-- Custom CSS -->
    <link href="{{ asset('public/assets/custom/css/style.css') }}" rel="stylesheet">

    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <div id="loading" class="overlay justify-content-center align-items-center" style="display: none;">
        <i class="fa fa-2x fa-sync fa-spin"></i>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>

        <a href="#" data-toggle="modal" data-target="#how-it-works-modal">How it Works?</a>
        <a href="https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm" target="_blank" class="btn btn-warning ml-auto">Install {{ $setting['site_name'] }}</a>
        <!-- Right navbar links -->
        <ul class="navbar-nav">
            <!-- User profile Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link py-1" data-toggle="dropdown" href="#">
                    <img src="{{ empty(Auth::user()->avatar) ? asset('public/assets/images/default-user.png') : Auth::user()->avatar }}"
                         alt="User Avatar" class="brand-image img-circle elevation-1 mt-0" style="opacity: .8">
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('profile') }}" class="dropdown-item">Profile</a>
                    <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar bg-light elevation-2">
        <!-- Brand Logo -->
        <a href="{{ route('index') }}" class="brand-link bg-white">
            <img src="{{ asset('public/'.$setting['site_logo']) }}" alt="Logo" class="brand-image img-circle elevation-1 mt-0" style="opacity: .8">
            <h3 class="brand-text m-0">{{ $setting['site_name'] }} <span class="text-warning" style="font-size: 16px">Beta</span></h3>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link @if($menu == 'Dashboard') active @endif">
                            <i class="nav-icon fa fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile') }}" class="nav-link @if($menu == 'Profile') active @endif">
                            <i class="nav-icon fa fa-user-circle"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('meetings') }}" class="nav-link @if($menu == 'Meetings') active @endif">
                            <i class="nav-icon fa fa-handshake"></i>
                            <p>Meetings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('guests') }}" class="nav-link @if($menu == 'Guests') active @endif">
                            <i class="nav-icon fa fa-users"></i>
                            <p>Guests</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('apps') }}" class="nav-link @if($menu == 'Apps') active @endif">
                            <i class="nav-icon fa fa-smile"></i>
                            <p>Apps</p>
                        </a>
                    </li>
                    @if (Auth::user()->slug)
                        <li class="nav-item has-treeview @if(in_array($menu, ['Schedules', 'Events'])) menu-open @endif">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-calendar-alt"></i>
                                <p>
                                    Pigeon Link
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('schedules') }}" class="nav-link @if($menu == 'Schedules') active @endif">
                                        <i class="nav-icon fa fa-clock"></i>
                                        <p>Schedules</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('events') }}" class="nav-link @if($menu == 'Events') active @endif">
                                        <i class="nav-icon fa fa-calendar-check"></i>
                                        <p>Events</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('availability') }}" class="nav-link @if($menu == 'Availability') active @endif">
                                <i class="nav-icon fa fa-calendar-alt"></i>
                                <p>Pigeon Link</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('membership') }}" class="nav-link @if($menu == 'Membership') active @endif">
                            <i class="nav-icon fa fa-cart-plus"></i>
                            <p>Membership</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
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
        <!-- Main content -->
        @if (!in_array($menu, ['Availability', 'Schedules', 'Events']))
        <?php
            $meetings = \App\Models\Meeting::where('user_id', Auth::id())->where('booking_time', 'like', date('Y-m-').'%')->get();
            $guests = \App\Models\Guest::where('user_id', Auth::id())->get();
            $apps = \App\Models\App::active()->limit(2)->get(['id', 'name']);
            $app = [];
            if (count($apps) > 0 && count($meetings) > 0) {
                foreach ($meetings as $meeting) {
                    if (empty($app[$meeting['app_id']])) $app[$meeting['app_id']] = 0;
                    $app[$meeting['app_id']]++;
                }
            }
            $first_day = \Carbon::now()->weekday(0)->subDays(7)->setTime(0, 0, 0).'';
            $end_day = \Carbon::now()->weekday(6)->subDays(7)->setTime(0, 0, 0).'';
            $last_week_meeting = \App\Models\Meeting::where('user_id', Auth::id())
                ->whereBetween('booking_time', [$first_day, $end_day])
                ->count();
            $last_week_guest = \App\Models\Guest::where('user_id', Auth::id())
                ->whereBetween('created_at', [$first_day, $end_day])
                ->count();
            $first_day = \Carbon::now()->weekday(0)->setTime(0, 0, 0).'';
            $end_day = \Carbon::now()->nextWeekendDay()->setTime(0, 0, 0).'';
            $this_week_meeting = \App\Models\Meeting::where('user_id', Auth::id())
                ->whereBetween('booking_time', [$first_day, $end_day])
                ->count();
            $this_week_guest = \App\Models\Guest::where('user_id', Auth::id())
                ->whereBetween('created_at', [$first_day, $end_day])
                ->count();
            $meeting_percent = empty($last_week_meeting) || empty($this_week_meeting) ? $this_week_meeting * 100 : (round($this_week_meeting / $last_week_meeting, 4) * 100 - 100);
            $guest_percent = empty($last_week_guest) || empty($this_week_guest) ? $this_week_guest * 100 : (round($this_week_guest / $last_week_guest, 4) * 100 - 100);
            $report = [
                'meetings' => count($meetings),
                'meeting_percent' => $meeting_percent,
                'guests' => count($guests),
                'guest_percent' => $guest_percent,
                'apps' => $apps,
                'app' => $app,
            ];
        ?>
        <section class="content-header py-5 px-sm-5 bg-regal-blue">
            <div class="container-fluid">

                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4">
                        <!-- small box -->
                        <div class="small-box bg-gradient-white">
                            <div class="inner">
                                <h4>Total Meetings</h4>
                                <h3 class="px-2">
                                    {{ Auth::user()->limitation }}
                                    <span class="text-small font-weight-normal">out of {{ Auth::user()->membership->limitation }} Allowed</span>
                                </h3>
                            </div>
                            <a href="{{ route('meetings') }}" class="small-box-footer bg-none">
                                @if ($report['meeting_percent'] > 0)
                                    <span class="text-success"><i class="fa fa-arrow-up"></i> {{ $report['meeting_percent'] }}% since last week</span>
                                @else
                                    <span class="text-danger"><i class="fa fa-arrow-down"></i> {{ abs($report['meeting_percent']) }}% since last week</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-4">
                        <!-- small box -->
                        <div class="small-box bg-gradient-white">
                            <div class="inner">
                                <h4>Total Guests</h4>
                                <h3 class="px-2">{{ $report['guests'] }}</h3>
                            </div>
                            <a href="{{ route('guests') }}" class="small-box-footer bg-none">
                                @if ($report['guest_percent'] > 0)
                                    <span class="text-success"><i class="fa fa-arrow-up"></i> {{ $report['guest_percent'] }}% since last week</span>
                                @else
                                    <span class="text-danger"><i class="fa fa-arrow-down"></i> {{ abs($report['guest_percent']) }}% since last week</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-4">
                        <!-- small box -->
                        <div class="small-box bg-gradient-white">
                            <div class="inner">
                                <h4 class="mb-3">Platforms</h4>
                                <div class="pt-1 px-2 text-center">
                                    <div class="row">
                                        @foreach ($report['apps'] as $item)
                                            <h4 class="col-8">{{ $item['name'] }}</h4><h4 class="col-4">{{ empty($report['app'][$item['id']]) ? 0 : $report['app'][$item['id']] }}</h4>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
        @endif

        @yield('content')

    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} </strong> All rights reserved.
        <div class="float-right d-none d-sm-inline-block text-uppercase">
            <b>{{ $setting['site_name'] }}</b>
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<?php
$video = $setting['how_video'];
if (stripos($video, 'youtube.com') !== false) {
    $video = str_replace('/watch?v=', '/embed/', $video);
    if (stripos($video, '?') !== false) {
        $video .= '&enablejsapi=1';
    } else {
        $video .= '?enablejsapi=1';
    }
}
?>
<!-- How it works Modal -->
<div class="modal fade" id="how-it-works-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">How Pigeon works?</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <iframe id="how-it-works-video" src="{{ $video }}" frameborder="0" style="width: 100%; height: 50vh;"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

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
<!-- InputMask -->
{{--<script src="../../plugins/inputmask/jquery.inputmask.bundle.js"></script>--}}
<script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('public/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/assets/dist/js/adminlte.js') }}"></script>

<!-- Custom -->
<script src="{{ asset('public/assets/custom/js/main.js') }}"></script>

<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#how-it-works-modal').on('hidden.bs.modal', function () {
            document.getElementById('how-it-works-video').contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
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
