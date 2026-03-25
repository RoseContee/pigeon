@extends('admin.partials.layout')

@section('title', 'Guests of '.$user['name'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Guests of {{ $user['name'] }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item active">Guests</li>
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
                        <a href="{{ route('admin.add-user-guest', $user['id']) }}" class="btn btn-primary"><i class="fa fa-plus"></i> New Guest</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="guests" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1; ?>
                            @foreach ($guests as $guest)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $guest['email'] }}</td>
                                    <td>{{ $guest['name'] }}</td>
                                    <td>
                                        <a href="{{ route('admin.edit-user-guest', [$user['id'], $guest['id']]) }}" class="btn text-primary"><i class="fa fa-edit"></i></a>
                                        <button class="btn text-danger" onclick="deleteGuest({{ $guest['id'] }})"><i class="fa fa-trash"></i></button>
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
                    <h4 class="modal-title"><i class="fa fa-warning text-warning"></i> Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.delete-user-guest', $user['id']) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="guest_id" value="" required>
                    <div class="modal-body">
                        <p>Are you sure to delete this guest?</p>
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
            $('#guests').DataTable({
                "dom": 'Bfrtip',
                "buttons": [
                    'pageLength',
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: [0, 1, 2],
                            modifier: {
                                selected: null
                            }
                        }
                    }
                ],
                "columnDefs": [
                    { "orderable": false, "targets": [3] },
                    { "searchable": false, "targets": [3] },
                    { "width": 10, "targets": 0 },
                    { "width": 100, "targets": [3] }
                ],
                "lengthMenu": [[100, 500,-1], [100, 500, "All"]],
                "oLanguage": {
                    "sEmptyTable": "No guests",
                    "sInfoEmpty": "",
                    "sZeroRecords": "No matching data",
                    "sInfo": "Total of _TOTAL_ guests",
                    "sLengthMenu": "_MENU_ per page",
                    "sInfoFiltered": " - filtering from _MAX_ guests"
                }
            });
        });

        function deleteGuest(id) {
            $('#delete-modal [name=guest_id]').val(id);
            $('#delete-modal').modal('show');
        }
    </script>
@endsection