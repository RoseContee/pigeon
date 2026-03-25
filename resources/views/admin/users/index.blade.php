@extends('admin.partials.layout')

@section('title', 'Users')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Guests / Meetings</th>
                                <th>Limitation</th>
                                <th>Event</th>
                                <th>Session</th>
                                <th>Membership</th>
                                <th>Start / End Membership</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1; ?>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>
                                        <img src="{{ empty($user['avatar']) ? asset('public/assets/images/default-user.png') : $user['avatar'] }}" width="50"
                                             class="img-circle" alt="User Avatar">
                                        <span class="d-none">{{ empty($user['avatar']) ? '' : $user['avatar'] }}</span>
                                    </td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>
                                        <a href="{{ route('admin.user-guests', $user['id']) }}">{{ $user['guests']->count() }}</a>
                                        /
                                        <a href="{{ route('admin.user-meetings', $user['id']) }}">{{ $user['meetings']->count() }}</a>
                                    </td>
                                    <td>
                                        <span id="user-limitation-{{ $user['id'] }}" class="btn px-0 py-1">{{ $user['limitation'] }}</span>
                                        <button class="btn text-primary px-2 py-1 float-right" onclick="editLimitation($(this))"
                                                data-id="{{ $user['id'] }}"><i class="fa fa-edit"></i></button>
                                    </td>
                                    <td>{{ $user['event'] }}</td>
                                    <td>
                                        <span id="user-schedule-{{ $user['id'] }}" class="btn px-0 py-1">{{ $user['schedule'] }}</span>
                                        <button class="btn text-primary px-2 py-1 float-right" onclick="editSchedule($(this))"
                                                data-id="{{ $user['id'] }}"><i class="fa fa-edit"></i></button>
                                    </td>
                                    <td>{{ empty($user['membership']) ? 'Removed by admin' : $user['membership']['name'] }}</td>
                                    <td>{{ date('d/m/Y', strtotime($user['start_date'])).' - '.date('d/m/Y', strtotime($user['end_date'])) }}</td>
                                    <td>
                                        <button class="btn @if ($user['active']) btn-success @else btn-danger @endif"
                                            onclick="activeUser($(this))" data-id="{{ $user['id'] }}">
                                            {{ $user['active'] ? 'Active' : 'Deactive' }}
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-user', $user['id']) }}" class="btn text-primary"><i class="fa fa-edit"></i></a>
                                        <button class="btn text-danger" onclick="deleteUser({{ $user['id'] }})"><i class="fa fa-trash"></i></button>
                                    </td>
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

    <!-- Edit Limitation Modal -->
    <div class="modal fade" id="limitation-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-info-circle text-info"></i> Meeting Limitation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label for="limitation" class="control-label">Limitation: <span class="required">*</span></label>
                                <input type="number" name="limitation" id="limitation" class="form-control" placeholder="Meeting Limitation" min="0" required>
                                <input type="hidden" id="limitation-user-id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="saveLimitation()">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Edit Limitation Modal -->
    <div class="modal fade" id="schedule-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-info-circle text-info"></i> Schedule Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label for="schedule" class="control-label">Session: <span class="required">*</span></label>
                                <input type="number" name="schedule" id="schedule" class="form-control" placeholder="Schedule Event" min="0" required>
                                <input type="hidden" id="schedule-user-id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="saveSchedule()">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-warning text-warning"></i> Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.delete-user') }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="user_id" value="" required>
                    <div class="modal-body">
                        <p>Are you sure to delete this user?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('style')
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('#users').DataTable({
                "dom": 'Bfrtip',
                "buttons": [
                    'pageLength',
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                            modifier: {
                                selected: null
                            }
                        }
                    }
                ],
                "columnDefs": [
                    { "orderable": false, "targets": [1, 9] },
                    { "searchable": false, "targets": [1, 9] },
                    { "width": 10, "targets": [0] },
                    { "width": 70, "targets": [8] },
                    { "width": 100, "targets": [9] }
                ],
                "lengthMenu": [[100, 500,-1], [100, 500, "All"]],
                "oLanguage": {
                    "sEmptyTable": "No users",
                    "sInfoEmpty": "",
                    "sZeroRecords": "No matching data",
                    "sInfo": "Total of _TOTAL_ users",
                    "sLengthMenu": "_MENU_ per page",
                    "sInfoFiltered": " - filtering from _MAX_ users"
                }
            });
        });

        function editLimitation(that) {
            var id = that.data('id');
            var limitation = $('#user-limitation-' + id).text().trim();
            $('#limitation-user-id').val(id);
            $('#limitation').val(limitation);
            $('#limitation-modal').modal('show');
        }

        function saveLimitation() {
            var id = $('#limitation-user-id').val();
            var limitation = $('#limitation').val();
            if (id == '') {
                alert('Some went error. Please try again.');
                $('#limitation-modal').modal('hide');
                return;
            }
            if (limitation == '') {
                alert('Please input limitation.');
                $('#limitation').focus();
                return;

            }
            if (limitation < 0) {
                alert('Limitation should be greater than 0.');
                $('#limitation').focus();
                return;
            }
            $.ajax({
                method: 'POST',
                url: '{{ route('admin.user-limitation') }}',
                data: {
                    user_id: id,
                    limitation: limitation,
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    if (data.result == 'success') {
                        toastr.success('Successfully Saved.');
                        $('#user-limitation-' + id).text(limitation);
                    } else {
                        toastr.error('Cannot find user');
                        location.reload(true);
                    }
                    $('#loading').hide();
                    $('#limitation-modal').modal('hide');
                },
                error: function(data) {
                    toastr.error('Some went error.');
                    location.reload(true);
                }
            })
        }

        function editSchedule(that) {
            var id = that.data('id');
            var schedule = $('#user-schedule-' + id).text().trim();
            $('#schedule-user-id').val(id);
            $('#schedule').val(schedule);
            $('#schedule-modal').modal('show');
        }

        function saveSchedule() {
            var id = $('#schedule-user-id').val();
            var schedule = $('#schedule').val();
            if (id == '') {
                alert('Some went error. Please try again.');
                $('#schedule-modal').modal('hide');
                return;
            }
            if (schedule == '') {
                alert('Please input schedule number.');
                $('#schedule').focus();
                return;

            }
            if (schedule < 0) {
                alert('Schedule number should be greater than 0.');
                $('#schedule').focus();
                return;
            }
            $.ajax({
                method: 'POST',
                url: '{{ route('admin.user-schedule') }}',
                data: {
                    user_id: id,
                    schedule: schedule,
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    if (data.result == 'success') {
                        toastr.success('Successfully Saved.');
                        $('#user-schedule-' + id).text(schedule);
                    } else {
                        toastr.error('Cannot find user');
                        location.reload(true);
                    }
                    $('#loading').hide();
                    $('#schedule-modal').modal('hide');
                },
                error: function(data) {
                    toastr.error('Some went error.');
                    location.reload(true);
                }
            })
        }

        function activeUser(that) {
            var id = that.data('id');
            $.ajax({
                method: 'POST',
                url: '{{ route('admin.active-user') }}',
                data: {
                    user_id: id,
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    if (data.result == 'success') {
                        if (data.active == 1) {
                            toastr.success('User activated successfully.');
                            that.removeClass('btn-danger').addClass('btn-success').text('Active');
                        } else {
                            toastr.success('User deactivated successfully.');
                            that.removeClass('btn-success').addClass('btn-danger').text('Deactive');
                        }
                    } else {
                        toastr.error('Cannot find user data');
                        location.reload(true);
                    }
                    $('#loading').hide();
                },
                error: function(data) {
                    toastr.error('Some went error.');
                    location.reload(true);
                }
            });
        }

        function deleteUser(id) {
            $('#delete-modal [name=user_id]').val(id);
            $('#delete-modal').modal('show');
        }
    </script>
@endsection