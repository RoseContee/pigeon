@extends('layouts')

@section('title', $event['user']['name'])

@section('seo')
    <meta name="description" content="{{ $event['description'] }}"/>

    <meta property="og:title" content="{{ $event['user']['name'] }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:description" content="{{ $event['description'] }}"/>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-12 text-left">
                        <a href="{{ route('user-events', $event['user']['slug']) }}" class="btn btn-default text-danger"
                           style="border-radius: 50%;"><i class="fa fa-arrow-left"></i></a>
                    </div>
                    <div class="col-12 mb-3">
                        <img src="{{ $event['user']['avatar'] }}" class="img-circle" alt="User Avatar" style="max-width: 70px;">
                    </div>
                    <div class="col-12 mb-4">
                        <h5 class="text-bold text-black-50">{{ $event['user']['name'] }}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h4>{{ $event['name'] }}</h4>
                        <p><i class="fa fa-clock-o"></i> {{ $event['duration'] }} min</p>
                        <p style="white-space: pre-line;">{{ $event['description'] }}</p>
                    </div>
                    <div class="col-md-8 border-md-left">
                        <div id="loading" class="overlay justify-content-center align-items-center position-absolute" style="display: none;">
                            <i class="fa fa-2x fa-spinner fa-spin position-absolute"></i>
                        </div>
                        <div id="datetimepicker" class="border-bottom"></div>
                        <div id="time-slots" class="row text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="booking-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('schedule-event', ['name' => $event['user']['slug'], 'event' => $event['slug']]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="date" value="">
                    <input type="hidden" name="time" value="">
                    <input type="hidden" name="timezone" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Book Event with {{ $event['user']['name'] }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row text-left">
                            <div class="col-12">
                                <div class="form-group @if ($errors->has('name')) has-error @endif">
                                    <label for="name">Name: <span class="required">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" required
                                           value="{{ old('name') }}">
                                    @if ($errors->has('name'))<span class="ml-2 small error">{{ $errors->first('name') }}</span>@endif
                                </div>

                                <div class="form-group @if ($errors->has('email')) has-error @endif">
                                    <label for="email">Email: <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" required
                                           value="{{ old('email') }}">
                                    @if ($errors->has('email'))<span class="ml-2 small error">{{ $errors->first('email') }}</span>@endif
                                </div>

                                <div class="form-group @if ($errors->has('name')) has-error @endif">
                                    <label for="phone">Phone Number: <span class="required">*</span></label>
                                    <input type="text" id="phone" name="phone" class="form-control" required
                                           value="{{ old('phone') }}">
                                    @if ($errors->has('phone'))<span class="ml-2 small error">{{ $errors->first('phone') }}</span>@endif
                                </div>
                            </div>
                            <div class="col-12 my-3">
                                <h4>{{ $event['name'] }}</h4>
                                <p class="mb-0"><i class="fa fa-calendar"></i> <span id="scheduled-time"></span>, <span id="scheduled-date"></span></p>
                                @if ($errors->has('date'))<span class="ml-3 small error">{{ $errors->first('date') }}</span>@endif
                                @if ($errors->has('time'))<span class="ml-3 small error">{{ $errors->first('time') }}</span>@endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Schedule Event</button>
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
        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        $(function() {
            $('#datetimepicker').datetimepicker({
                locale:  moment.locale('en', {
                    week: { dow: 1 }
                }),
                format: 'L',
                inline: true,
                daysOfWeekDisabled: [
                    @foreach($weeks as $week)
                        {{ $week }},
                    @endforeach
                ],
                useCurrent: false,
                minDate: new Date('{{ $minDate }}'),
                @if ($maxDate)
                    maxDate: new Date('{{ $maxDate }}'),
                @endif
            });

            $('#datetimepicker').on('change.datetimepicker', function(e) {
                getTimeSlots(moment(e.date).format('YYYY-MM-DD'));
            });

            $('#booking-modal').on('hidden.bs.modal', function () {
                $('#scheduled-time').text('');
                $('#scheduled-date').text('');
                $('[name=date]').val('');
                $('[name=time]').val('');
            });

            $('[name=timezone]').val(timezone);
        });

        @if ($errors->any())
            $('#booking-modal').modal('show');
        @endif

        function getTimeSlots(date) {
            $.ajax({
                method: 'GET',
                url: '{{ route('time-slots') }}',
                data: {
                    host: '{{ $event['user']['slug'] }}',
                    event: '{{ $event['slug'] }}',
                    date: date,
                    timezone: timezone,
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    if (data.status == 'failed') {
                        location.reload(true);
                        return;
                    }
                    $('#time-slots').html(data.time_slots).addClass('mt-3');
                    $('#loading').hide();
                },
                error: function() {
                    location.reload(true);
                }
            });
        }

        function openBookingModal(that) {
            var schedule = that.data('schedule'), date = that.data('date'),
                from = that.data('from'), to = that.data('to');
            $('#scheduled-time').text(from + ' - ' + to);
            $('#scheduled-date').text(schedule);
            $('[name=date]').val(date);
            $('[name=time]').val(from);
            $('#booking-modal').modal('show');
        }
    </script>
@endsection