@extends('user.partials.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">Meetings Today ({{ date('d/m/Y') }})</h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @if (count($meetings) == 0)
                    <div class="col-12 pl-5">
                        No meeting today.
                    </div>
                @endif
                @foreach ($meetings as $meeting)
                    <div class="col-lg-4 col-sm-6">
                        <div class="card">
                            <div class="card-header p-2">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="meeting-badge p-1
                                            @if ($meeting['app_id'] % 7 == 1) bg-danger @elseif ($meeting['app_id'] % 7 == 2) bg-info @elseif ($meeting['app_id'] % 7 == 3) bg-success
                                            @elseif ($meeting['app_id'] % 7 == 4) bg-warning @elseif ($meeting['app_id'] % 7 == 5) bg-primary @elseif ($meeting['app_id'] % 7 == 6) bg-secondary
                                            @else bg-gray @endif">{{ !empty($meeting['app']) ? $meeting['app']['name'] : 'Unknown' }}</span>
                                    </div>
                                    <div class="col-6 text-right">
                                        <?php
                                        $meeting['booking_time'] = convertTimezone($meeting['timezone'], $timezone, $meeting['booking_time']);
                                        ?>
                                        {{ date('h:i A', strtotime($meeting['booking_time'])) }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-2">
                                <div class="row mb-3">
                                    <div class="col-12">{{ $meeting['event_name'] }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-6 text-bold">Host</div>
                                    <div class="col-6 text-bold">Guests</div>
                                </div>
                                <div class="row">
                                    <div class="col-6">{{ $meeting['host_name'] }}</div>
                                    <div class="col-6">
                                        <?php $guests = explode(',', $meeting['guests']); ?>
                                        @foreach ($guests as $guest)
                                            {{ $guest }} <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">Upcoming Meetings</h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @if (count($upcomings) == 0)
                    <div class="col-12 pl-5">No upcoming meetings.</div>
                @endif
                @foreach ($upcomings as $upcoming)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    $upcoming['booking_time'] = convertTimezone($upcoming['timezone'], $timezone, $upcoming['booking_time']);
                                    ?>
                                    <div class="col-12 text-bold">{{ date('d/m/Y', strtotime($upcoming['booking_time'])) }}</div>
                                    <div class="col-12">{{ date('h:i A', strtotime($upcoming['booking_time'])) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('script')
@endsection