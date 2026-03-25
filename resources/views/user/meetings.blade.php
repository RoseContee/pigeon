@extends('user.partials.layout')

@section('title', 'Meetings')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">Meetings</h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12">
                    <button class="btn btn-primary"><i class="fa fa-handshake"></i> New Meeting</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table id="meetings" class="table table-striped table-bordered table-hover" role="grid">
                        <thead>
                        <tr>
                            <th style="display: none;">No</th>
                            <th>Platform</th>
                            <th>Appointment Time</th>
                            <th>Event Name</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $index = 0; $now = date('Y-m-d H:i:s'); ?>
                        @foreach ($meetings as $meeting)
                            <tr>
                                <td style="display: none;">{{ $index++ }}</td>
                                <td>{{ $meeting['app']['name'] }}</td>
                                <?php
                                $meeting_time = date_create($meeting['booking_time'], timezone_open($meeting['timezone']));
                                if ($timezone != 'Unknown') {
                                    date_timezone_set($meeting_time, timezone_open($timezone));
                                }
                                $meeting['booking_time'] = $meeting_time->format('Y-m-d H:i:s');
                                ?>
                                <td>{{ date('d/m/Y h:i A', strtotime($meeting['booking_time'])) }}</td>
                                <td>{{ $meeting['event_name'] }}</td>
                                <td>
                                    @if ($meeting['booking_time'] < $now)
                                        <span class="badge badge-success">Completed</span>
                                    @else
                                        <span class="badge badge-info">Scheduled</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('#meetings').dataTable({
                "columnDefs": [
                    { "orderable": false, "targets": [2] },
                    { "searchable": false, "targets": [] }
                ],
                "lengthMenu": [[50, 100, 200, 500], [50, 100, 200, 500]],
                "oLanguage": {
                    "sEmptyTable": "No scheduled meeting",
                    "sInfoEmpty": "",
                    "sZeroRecords": "No matching data",
                    "sInfo": "Total of _TOTAL_ meetings to display (_START_ to _END_)",
                    "sLengthMenu": "_MENU_ per page",
                    "sInfoFiltered": " - filtering from _MAX_ meetings"
                }
            });
        });
    </script>
@endsection