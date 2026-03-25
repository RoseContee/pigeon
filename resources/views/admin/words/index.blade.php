@extends('admin.partials.layout')

@section('title', 'Words')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Words</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Words</li>
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
                        <a href="{{ route('admin.add-word') }}" class="btn btn-primary"><i class="fa fa-plus"></i> New Word</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="words" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1; ?>
                            @foreach ($words as $word)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $word['word'] }}</td>
                                    <td>
                                        <a href="{{ route('admin.edit-word', $word['id']) }}" class="btn text-primary"><i class="fa fa-edit"></i></a>
                                        <button class="btn text-danger" onclick="deleteWord({{ $word['id'] }})"><i class="fa fa-trash"></i></button>
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
                    <h4 class="modal-title"><i class="fa fa-warning text-warning"></i> Delete Word</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.delete-word') }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="word_id" value="" required>
                    <div class="modal-body">
                        <p>Are you sure to delete this word?</p>
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
            $('#words').DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": [2] },
                    { "searchable": false, "targets": [2] },
                    { "width": 10, "targets": 0 },
                    { "width": 100, "targets": [2] }
                ],
                "lengthMenu": [[5, 10,-1], [5, 10, "All"]],
                "oLanguage": {
                    "sEmptyTable": "No words",
                    "sInfoEmpty": "",
                    "sZeroRecords": "No matching data",
                    "sInfo": "Total of _TOTAL_ words",
                    "sLengthMenu": "_MENU_ per page",
                    "sInfoFiltered": " - filtering from _MAX_ words"
                }
            });
        });

        function deleteWord(id) {
            $('#delete-modal [name=word_id]').val(id);
            $('#delete-modal').modal('show');
        }
    </script>
@endsection