@extends('user.partials.layout')

@section('title', 'My Schedules')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">My Schedules</h4>
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
                    <a href="{{ route('new-schedule') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> New Schedule</a>
                </div>
            </div>
            <div class="row">
                @foreach ($schedules as $schedule)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div id="event-{{ $schedule['slug'] }}" class="card">
                            <div class="card-header p-3">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <label class="switch mt-2">
                                            <input type="checkbox" data-link="{{ $schedule['slug'] }}" @if($schedule['active']) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('edit-schedule', $schedule['slug']) }}" class="btn btn-default px-2 py-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-danger px-2 py-1" onclick="deleteSchedule('{{ $schedule['slug'] }}')">
                                            <i class="fa fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <h5 class="ellipsis-title mb-0 @if ($schedule['active'] == 0) text-gray @endif">{{ $schedule['name'] }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-warning text-warning"></i> Delete Schedule</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('delete-schedule') }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="link" value="">
                    <div class="modal-body">
                        <p>Are you sure to delete this schedule?</p>
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
            $('input[type=checkbox]').on('change', function(e) {
                var slug = $(this).data('link');
                $.ajax({
                    method: 'POST',
                    url: '{{ route('active-schedule') }}',
                    data: {
                        slug: slug
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                            if (data.active == 1) {
                                $('#event-' + slug + ' .card-body h5').removeClass('text-gray');
                            } else {
                                $('#event-' + slug + ' .card-body h5').addClass('text-gray');
                            }
                        } else {
                            location.reload(true);
                        }
                    },
                    error: function (data) {
                        location.reload(true);
                    }
                });
            });
        });

        function deleteSchedule(link) {
            $('[name=link]').val(link);
            $('#delete-modal').modal('show');
        }
    </script>
@endsection