@extends('user.partials.layout')

@section('title', 'Availability')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h5 class="m-0 text-dark">
                        <a href="{{ $link }}" target="_blank">{{ $link }}</a>
                    </h5>
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
                    <a href="{{ route('new-event') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> New Event</a>
                </div>
            </div>
            <div class="row">
                @foreach ($events as $event)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div id="event-{{ $event['slug'] }}" class="card">
                            <div class="card-header p-3">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <label class="switch mt-2">
                                            <input type="checkbox" data-link="{{ $event['slug'] }}" @if($event['active']) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('edit-event', $event['slug']) }}" class="btn btn-default px-2 py-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-danger px-2 py-1" onclick="deleteEvent('{{ $event['slug'] }}')">
                                            <i class="fa fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <h5 class="ellipsis-title mb-0 @if ($event['active'] == 0) text-gray @endif">{{ $event['name'] }}</h5>
                            </div>
                            <div class="card-footer p-3">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        @if ($event['active'])
                                            <a href="{{ route('user-event', ['name' => Auth::user()->slug, 'event' => $event['slug']]) }}"
                                               target="_blank" class="d-block ellipsis">/{{ $event['slug'] }}</a>
                                        @else
                                            <span class="d-block ellipsis text-gray">/{{ $event['slug'] }}</span>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        @if ($event['active'])
                                            <button class="btn btn-default btn-block text-primary" onclick="copyClipboard($(this))"
                                                    data-link="{{ route('user-event', ['name' => Auth::user()->slug, 'event' => $event['slug']]) }}">Copy Link</button>
                                        @else
                                            <button class="btn btn-default btn-block text-gray" disabled>Copy Link</button>
                                        @endif
                                    </div>
                                </div>
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
                    <h4 class="modal-title"><i class="fa fa-warning text-warning"></i> Delete Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('delete-event') }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="link" value="">
                    <div class="modal-body">
                        <p>Are you sure to delete this event?</p>
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
                    url: '{{ route('active-event') }}',
                    data: {
                        slug: slug
                    },
                    success: function (data) {
                        if (data.status == 'success') {
                            if (data.expired == 1) {
                                toastr.error('This event has been expired');
                                return;
                            }
                            if (data.active == 1) {
                                $('#event-' + slug + ' .card-body h5').removeClass('text-gray');
                            } else {
                                $('#event-' + slug + ' .card-body h5').addClass('text-gray');
                            }
                            $('#event-' + slug + ' .card-footer').html(data.event_link);
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

        function deleteEvent(link) {
            $('[name=link]').val(link);
            $('#delete-modal').modal('show');
        }
    </script>
@endsection