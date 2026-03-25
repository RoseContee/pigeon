@extends('admin.partials.layout')

@section('title', 'Guests of '.$user['name'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Meetings of {{ $user['name'] }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item active">Meetings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="guests" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Event Name</th>
                                <th>App</th>
                                <th>Host</th>
                                <th>Booking Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1; ?>
                            @foreach ($meetings as $meeting)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $meeting['event_name'] }}</td>
                                    <td>{{ $meeting['app']['name'] }}</td>
                                    <td>{{ $meeting['host_name'] }}</td>
                                    <?php
                                    $meeting['booking_time'] = convertTimezone($meeting['timezone'], $timezone, $meeting['booking_time']);
                                    ?>
                                    <td>{{ date('d/m/Y h:i A', strtotime($meeting['booking_time'])) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('style')
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('#guests').DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": [3] },
                    { "searchable": false, "targets": [3] },
                    { "width": 10, "targets": 0 },
                    { "width": 100, "targets": [3] }
                ],
                "lengthMenu": [[100, 500,-1], [100, 500, "All"]],
                "oLanguage": {
                    "sEmptyTable": "No meetings",
                    "sInfoEmpty": "",
                    "sZeroRecords": "No matching data",
                    "sInfo": "Total of _TOTAL_ meetings",
                    "sLengthMenu": "_MENU_ per page",
                    "sInfoFiltered": " - filtering from _MAX_ meetings"
                }
            });
        });
    </script>
@endsection