@extends('admin.partials.layout')

@section('title', 'Apps')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Apps</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Apps</li>
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
                        <a href="{{ route('admin.add-app') }}" class="btn btn-primary"><i class="fa fa-plus"></i> New App</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="apps" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1; ?>
                            @foreach ($apps as $app)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $app['name'] }}</td>
                                    <td>
                                        @if (!empty($app['image']))
                                            <img src="{{ asset('public/uploads/'.$app['image']) }}"
                                                 alt="App Image" style="width: 150px;">
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn @if ($app['active']) btn-success @else btn-danger @endif"
                                            onclick="activeApp($(this))" data-id="{{ $app['id'] }}">
                                            {{ $app['active'] ? 'Active' : 'Deactive' }}
                                        </button>
                                    </td>
                                    <td style="width: 100px;">
                                        <a href="{{ route('admin.edit-app', $app['id']) }}" class="btn text-primary"><i class="fa fa-edit"></i></a>
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
@endsection

@section('style')
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('#apps').DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": [2, 3] },
                    { "searchable": false, "targets": [3] },
                    { "width": 10, "targets": 0 },
                    { "width": 70, "targets": [2] },
                    { "width": 100, "targets": [3] }
                ],
                "lengthMenu": [[5, 10,-1], [5, 10, "All"]],
                "oLanguage": {
                    "sEmptyTable": "No apps",
                    "sInfoEmpty": "",
                    "sZeroRecords": "No matching data",
                    "sInfo": "Total of _TOTAL_ apps",
                    "sLengthMenu": "_MENU_ per page",
                    "sInfoFiltered": " - filtering from _MAX_ apps"
                }
            });
        });

        function activeApp(that) {
            var id = that.data('id');
            $.ajax({
                method: 'POST',
                url: '{{ route('admin.active-app') }}',
                data: {
                    app_id: id,
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    if (data.result == 'success') {
                        if (data.active == 1) {
                            toastr.success('App activated successfully.');
                            that.removeClass('btn-danger').addClass('btn-success').text('Active');
                        } else {
                            toastr.success('App deactivated successfully.');
                            that.removeClass('btn-success').addClass('btn-danger').text('Deactive');
                        }
                    } else {
                        toastr.error('Cannot find app data');
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
    </script>
@endsection