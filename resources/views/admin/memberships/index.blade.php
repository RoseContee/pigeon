@extends('admin.partials.layout')

@section('title', 'Memberships')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Memberships</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Memberships</li>
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
                    <div class="card-header">
                        <a href="{{ route('admin.add-membership') }}" class="btn btn-primary"><i class="fa fa-plus"></i> New Membership</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="memberships" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Package</th>
                                <th>Price</th>
                                <th>Limitation</th>
                                <th>Description</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1; ?>
                            @foreach ($memberships as $membership)
                                @if (empty($membership['membership_package'])) @continue @endif
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $membership['name'] }}</td>
                                    <td>{{ $membership['membership_package']['name'] }}</td>
                                    <td>${{ $membership['price'] }}</td>
                                    <td>{{ $membership['limitation'] }}</td>
                                    <td style="white-space: pre;">{{ $membership['description'] }}</td>
                                    <td>
                                        <button class="btn @if ($membership['active']) btn-success @else btn-danger @endif"
                                            onclick="activeMembership($(this))" data-id="{{ $membership['id'] }}">
                                            {{ $membership['active'] ? 'Active' : 'Deactive' }}
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.edit-membership', $membership['id']) }}" class="btn text-primary"><i class="fa fa-edit"></i></a>
                                        <button class="btn text-danger" onclick="deleteMembership({{ $membership['id'] }})"><i class="fa fa-trash"></i></button>
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

    <!-- Delete Modal -->
    <div class="modal fade" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-warning text-warning"></i> Delete Membership</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.delete-membership') }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="membership_id" value="" required>
                    <div class="modal-body">
                        <p>Are you sure to delete this membership?</p>
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
            $('#memberships').DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": [6, 7] },
                    { "searchable": false, "targets": [7] },
                    { "width": 10, "targets": 0 },
                    { "width": 70, "targets": [6] },
                    { "width": 100, "targets": [7] }
                ],
                "lengthMenu": [[5, 10,-1], [5, 10, "All"]],
                "oLanguage": {
                    "sEmptyTable": "No memberships",
                    "sInfoEmpty": "",
                    "sZeroRecords": "No matching data",
                    "sInfo": "Total of _TOTAL_ memberships",
                    "sLengthMenu": "_MENU_ per page",
                    "sInfoFiltered": " - filtering from _MAX_ memberships"
                }
            });
        });

        function activeMembership(that) {
            var id = that.data('id');
            $.ajax({
                method: 'POST',
                url: '{{ route('admin.active-membership') }}',
                data: {
                    membership_id: id,
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    if (data.result == 'success') {
                        if (data.active == 1) {
                            toastr.success('Membership activated successfully.');
                            that.removeClass('btn-danger').addClass('btn-success').text('Active');
                        } else {
                            toastr.success('Membership deactivated successfully.');
                            that.removeClass('btn-success').addClass('btn-danger').text('Deactive');
                        }
                    } else {
                        toastr.error('Cannot find membership data');
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

        function deleteMembership(id) {
            $('#delete-modal [name=membership_id]').val(id);
            $('#delete-modal').modal('show');
        }
    </script>
@endsection