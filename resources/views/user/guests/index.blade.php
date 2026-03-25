@extends('user.partials.layout')

@section('title', 'Guests')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">Guests</h4>
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
                    <a href="{{ route('add-guest') }}" class="btn btn-primary"><i class="fa fa-user-plus"></i> Add Guest</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table id="guests" class="table table-striped table-bordered table-hover" role="grid" style="width: 100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($guests as $guest)
                            <tr>
                                <td></td>
                                <td>{{ $guest['email'] }}</td>
                                <td>{{ $guest['name'] }}</td>
                                <td>
                                    <a href="{{ route('edit-guest', $guest['email']) }}" class="text-success p-1 mr-2"><i class="fa fa-user-edit"></i></a>
                                    <a href="javascript:void(0);" class="text-danger p-1" onclick="deleteGuest('{{ $guest['email'] }}')"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-warning text-warning"></i> Delete Guest</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('delete-guest') }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="email" value="">
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
        $(function() {
            $('#guests').DataTable({
                "dom": 'Bfrtip',
                "buttons": [
                    'pageLength',
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [1, 2]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [1, 2]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [1, 2]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [1, 2]
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: [1, 2],
                            modifier: {
                                selected: null
                            }
                        }
                    }
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                "columnDefs": [
                    { "orderable": false, "className": 'select-checkbox', "targets": 0 },
                    { "orderable": false, "targets": 3 },
                    { "searchable": false, "targets": [] },
                    { "width": 10, "targets": 0 },
                    { "width": 70, "targets": 3 }
                ],
                "lengthMenu": [[5, 10,-1], [5, 10, "All"]],
                "oLanguage": {
                    "sEmptyTable": "No guest",
                    "sInfoEmpty": "",
                    "sZeroRecords": "No matching data",
                    "sInfo": "Total of _TOTAL_ guests",
                    "sLengthMenu": "_MENU_ per page",
                    "sInfoFiltered": " - filtering from _MAX_ guests"
                }
            });
        });

        function deleteGuest(email) {
            $('[name=email]').val(email);
            $('#delete-modal').modal('show');
        }
    </script>
@endsection