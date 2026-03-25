@extends('admin.partials.layout')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <h5 class="mb-2">Incomes</h5>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Income</span>
                            <span class="info-box-number">$0</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">This month</span>
                            <span class="info-box-number">$0</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cart-plus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Packages</span>
                            <span class="info-box-number">{{ $package_number }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <h5 class="mb-2">Report</h5>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $platform_number }}</h3>

                            <p>Platforms</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-smile"></i>
                        </div>
                        <a href="{{ route('admin.platforms') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-12 col-md-6 col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $app_number }}</h3>

                            <p>Meeting Apps</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <a href="{{ route('admin.apps') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-12 col-md-6 col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $user_number }}</h3>

                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('admin.users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header no-border">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Users Report (Weekly)</h3>
                                <a href="{{ route('admin.users') }}">View all</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">{{ $this_week_user }}</span>
                                    <span>This week</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if ($user_percent > 0)
                                        <span class="text-success"><i class="fas fa-arrow-up"></i> {{ $user_percent }}%</span>
                                    @else
                                        <span class="text-danger"><i class="fas fa-arrow-down"></i> {{ abs($user_percent) }}%</span>
                                    @endif
                                    <span class="text-muted">Since last week</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="users-chart" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This week
                                </span>
                                <span>
                                    <i class="fas fa-square text-gray"></i> Last week
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header no-border">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Incomes Report</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">$0.00</span>
                                    <span>This month</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 1%
                                    </span>
                                    <span class="text-muted">Since last month</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="incomes-chart" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This year
                                </span>

                                <span>
                                    <i class="fas fa-square text-gray"></i> Last year
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            'use strict';

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            };

            var mode      = 'index';
            var intersect = true;

            var $visitorsChart = $('#users-chart');
            var visitorsChart  = new Chart($visitorsChart, {
                data   : {
                    labels  : [@foreach ($days as $day)'{{ $day }}', @endforeach],
                    datasets: [{
                        type                : 'line',
                        data                : [@foreach ($this_data as $d){{ $d }}, @endforeach],
                        backgroundColor     : 'transparent',
                        borderColor         : '#007bff',
                        pointBorderColor    : '#007bff',
                        pointBackgroundColor: '#007bff',
                        fill                : false
                    },
                    {
                        type                : 'line',
                        data                : [@foreach ($last_data as $d){{ $d }}, @endforeach],
                        backgroundColor     : 'tansparent',
                        borderColor         : '#ced4da',
                        pointBorderColor    : '#ced4da',
                        pointBackgroundColor: '#ced4da',
                        fill                : false
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips           : {
                        mode     : mode,
                        intersect: intersect
                    },
                    hover              : {
                        mode     : mode,
                        intersect: intersect
                    },
                    legend             : {
                        display: false
                    },
                    scales             : {
                        yAxes: [{
                            gridLines: {
                                display      : true,
                                lineWidth    : '4px',
                                color        : 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks    : $.extend({
                                beginAtZero : true,
                                //suggestedMax: 200
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display  : true,
                            gridLines: {
                                display: false
                            },
                            ticks    : ticksStyle
                        }]
                    }
                }
            })

            var $incomesChart = $('#incomes-chart');
            var incomesChart  = new Chart($incomesChart, {
                type   : 'bar',
                data   : {
                    labels  : ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                    datasets: [
                        {
                            backgroundColor: '#007bff',
                            borderColor    : '#007bff',
                            data           : [1000, 2000, 3000, 2500, 2700, 2500, 3000]
                        },
                        {
                            backgroundColor: '#ced4da',
                            borderColor    : '#ced4da',
                            data           : [700, 1700, 2700, 2000, 1800, 1500, 2000]
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips           : {
                        mode     : mode,
                        intersect: intersect
                    },
                    hover              : {
                        mode     : mode,
                        intersect: intersect
                    },
                    legend             : {
                        display: false
                    },
                    scales             : {
                        yAxes: [{
                            gridLines: {
                                display      : true,
                                lineWidth    : '4px',
                                color        : 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks    : $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    if (value >= 1000) {
                                        value /= 1000;
                                        value += 'k'
                                    }
                                    return '$' + value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display  : true,
                            gridLines: {
                                display: false
                            },
                            ticks    : ticksStyle
                        }]
                    }
                }
            });
        });
    </script>
@endsection