@extends('user.partials.layout')

@section('title', 'Meetings')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">Apps</h4>
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
                <div class="col-12">
                    <table id="meetings" class="table table-striped table-bordered table-hover" role="grid">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>App</th>
                            <th>Meeting Link</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $index = 1;?>
                        @foreach ($apps as $app)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $app['name'] }}</td>
                                <td>
                                    Automatically generated
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
                    { "searchable": false, "targets": [2] }
                ],
                "lengthMenu": [[50, 100, 200, 500], [50, 100, 200, 500]],
                "oLanguage": {
                    "sEmptyTable": "No apps",
                    "sInfoEmpty": "",
                    "sZeroRecords": "No matching data",
                    "sInfo": "Total of _TOTAL_ apps to display (_START_ to _END_)",
                    "sLengthMenu": "_MENU_ per page",
                    "sInfoFiltered": " - filtering from _MAX_ apps"
                }
            });
        });
    </script>
@endsection