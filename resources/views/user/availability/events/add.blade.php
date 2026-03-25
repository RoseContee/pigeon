@extends('user.partials.layout')

@section('title', 'User Event')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">{{ empty($event) ? 'New Event' : 'Edit Event('.$event['name'].')' }}</h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="content mb-3">
        <div class="container-fluid">
            <div class="row">
                @if (!empty($event) || $current_event < Auth::user()->event)
                    <div class="col-xl-6 col-lg-8">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="timezone" value="">
                            <div class="form-group @if ($errors->has('name')) has-error @endif">
                                <label for="name">Name: <span class="required">*</span></label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Event Name"
                                       value="{{ old('name', empty($event) ? '' : $event['name']) }}" required>
                                @if ($errors->has('name'))<span class="ml-2 small error">{{ $errors->first('name') }}</span>@endif
                            </div>

                            <div class="form-group @if ($errors->has('description')) has-error @endif">
                                <label for="description">Description: <span class="required">*</span></label>
                                <textarea type="text" id="description" name="description" class="form-control" placeholder="Event Description" rows="5"
                                          required>{{ old('description', empty($event) ? '' : $event['description']) }}</textarea>
                                @if ($errors->has('description'))<span class="ml-2 small error">{{ $errors->first('description') }}</span>@endif
                            </div>

                            <div class="form-group @if ($errors->has('date_range')) has-error @endif">
                                <label>Date Range: <span class="required">*</span></label>
                                <label class="form-check" onclick="$('#days').focus()">
                                    <input class="form-check-input" type="radio" name="date_range" required
                                           value="days" @if (old('date_range') == 'days' || empty($event)) checked @endif>
                                    <div class="input-group">
                                        <input type="number" id="days" name="days" class="form-control"
                                               onclick="$(this).parent().parent().click()" value="{{ old('days', 60) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-0">days</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="form-check" onclick="$('#daterange').focus()">
                                    <input class="form-check-input" type="radio" name="date_range" required
                                           value="daterange" @if (old('date_range') == 'daterange' || !empty($event)) checked @endif>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0">Within date</span>
                                        </div>
                                        <input type="text" id="daterange" name="daterange" class="form-control"
                                               onclick="$(this).parent().parent().click()">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </label>
                                <label class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="date_range" required
                                           value="indefinite" @if (old('date_range') == 'indefinite') checked @endif>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0">Indefinitely in the future</span>
                                        </div>
                                    </div>
                                </label>
                                @if ($errors->has('date_range'))<span class="ml-2 small error">{{ $errors->first('date_range') }}</span>@endif
                            </div>

                            <label>Time Slots</label>
                            <div class="form-group @if ($errors->has('time_slot')) has-error @endif">
                                <label class="form-check">
                                    <input class="form-check-input" type="radio" name="time_slot" required
                                           value="schedule" @if (old('time_slot') == 'schedule' || empty($event) || !empty($event['schedule'])) checked @endif>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0">Use an existing schedule</span>
                                        </div>
                                        <select id="schedule" name="schedule" class="form-control"
                                                @if (old('time_slot') != 'schedule' && !empty($event) && empty($event['schedule'])) style="display: none;" @endif>
                                            @foreach ($schedules as $schedule)
                                                <option value="{{ $schedule['id'] }}"
                                                    @if ($schedule['id'] == old('schedule', empty($event) ? '' : $event['schedule_id'])) selected @endif>{{ $schedule['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </label>
                                <label class="form-check mb-0">
                                    <input class="form-check-input" type="radio" name="time_slot" required
                                           value="custom" @if (old('time_slot') == 'custom' || (!empty($event) && empty($event['schedule']))) checked @endif>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-0">Set custom hours</span>
                                        </div>
                                    </div>
                                </label>
                                @if ($errors->has('time_slot'))<span class="ml-2 small error">{{ $errors->first('time_slot') }}</span>@endif
                            </div>

                            <div id="custom" @if (old('time_slot') != 'custom' && (empty($event) || !empty($event['schedule']))) style="display: none;" @endif>
                                <div class="form-group mb-0 @if ($errors->has('mon')) has-error @endif">
                                    <label>Monday: <span class="required">*</span></label>
                                    @include('user.partials.availability.time-slots', ['week' => 'mon', 'item' => $event])
                                    @if ($errors->has('mon'))<span class="ml-2 small error">{{ $errors->first('mon') }}</span>@endif
                                </div>
                                @include('user.partials.availability.apply-to', ['week' => 'mon', 'item' => $event])

                                <div class="form-group mb-0 @if ($errors->has('tue')) has-error @endif tue">
                                    <label>Tuesday: <span class="required">*</span></label>
                                    @include('user.partials.availability.time-slots', ['week' => 'tue', 'item' => $event])
                                    @if ($errors->has('tue'))<span class="ml-2 small error">{{ $errors->first('tue') }}</span>@endif
                                </div>
                                @include('user.partials.availability.apply-to', ['week' => 'tue', 'item' => $event])

                                <div class="form-group mb-0 @if ($errors->has('wed')) has-error @endif wed">
                                    <label>Wednesday: <span class="required">*</span></label>
                                    @include('user.partials.availability.time-slots', ['week' => 'wed', 'item' => $event])
                                    @if ($errors->has('wed'))<span class="ml-2 small error">{{ $errors->first('wed') }}</span>@endif
                                </div>
                                @include('user.partials.availability.apply-to', ['week' => 'wed', 'item' => $event])

                                <div class="form-group mb-0 @if ($errors->has('thu')) has-error @endif thu">
                                    <label>Thursday: <span class="required">*</span></label>
                                    @include('user.partials.availability.time-slots', ['week' => 'thu', 'item' => $event])
                                    @if ($errors->has('thu'))<span class="ml-2 small error">{{ $errors->first('thu') }}</span>@endif
                                </div>
                                @include('user.partials.availability.apply-to', ['week' => 'thu', 'item' => $event])

                                <div class="form-group @if ($errors->has('fri')) has-error @endif fri">
                                    <label>Friday: <span class="required">*</span></label>
                                    @include('user.partials.availability.time-slots', ['week' => 'fri', 'item' => $event])
                                    @if ($errors->has('fri'))<span class="ml-2 small error">{{ $errors->first('fri') }}</span>@endif
                                </div>
                                @include('user.partials.availability.apply-to', ['week' => 'fri', 'item' => $event])

                                <div class="form-group @if ($errors->has('sat')) has-error @endif sat">
                                    <label>Saturday: <span class="required">*</span></label>
                                    @include('user.partials.availability.time-slots', ['week' => 'sat', 'item' => $event])
                                    @if ($errors->has('sat'))<span class="ml-2 small error">{{ $errors->first('sat') }}</span>@endif
                                </div>
                                @include('user.partials.availability.apply-to', ['week' => 'sat', 'item' => $event])

                                <div class="form-group @if ($errors->has('sun')) has-error @endif sun">
                                    <label>Sunday: <span class="required">*</span></label>
                                    @include('user.partials.availability.time-slots', ['week' => 'sun', 'item' => $event])
                                    @if ($errors->has('sun'))<span class="ml-2 small error">{{ $errors->first('sun') }}</span>@endif
                                </div>
                            </div>

                            <div class="form-group @if ($errors->has('duration')) has-error @endif">
                                <label for="duration">Duration (in minutes): <span class="required">*</span></label>
                                <input type="number" id="duration" name="duration" class="form-control" placeholder="Event will go for this time" min="0" max="60" step="5"
                                       value="{{ old('duration', empty($event) ? '15' : $event['duration']) }}" required>
                                @if ($errors->has('duration'))<span class="ml-2 small error">{{ $errors->first('duration') }}</span>@endif
                            </div>

                            <div class="form-group @if ($errors->has('break_time')) has-error @endif">
                                <label for="break_time">Break Time (in minutes): <span class="required">*</span></label>
                                <input type="number" id="break_time" name="break_time" class="form-control" placeholder="Break time between events" min="0" max="60" step="5"
                                       value="{{ old('break_time', empty($event) ? '0' : $event['break_time']) }}" required>
                                @if ($errors->has('break_time'))<span class="ml-2 small error">{{ $errors->first('break_time') }}</span>@endif
                            </div>

                            <div class="form-group @if ($errors->has('status')) has-error @endif">
                                <label for="status">Status: </label>
                                <select id="status" name="status" class="form-control">
                                    <option value="0" @if (old('status', empty($event) ? 0 : $event['active']) == 0) selected @endif>Deactive</option>
                                    <option value="1" @if (old('status', empty($event) ? 0 : $event['active']) == 1) selected @endif>Active</option>
                                </select>
                                @if ($errors->has('status'))<span class="ml-2 small error">{{ $errors->first('status') }}</span>@endif
                            </div>

                            <button type="submit" class="btn btn-primary">{{ empty($event) ? 'Save' : 'Update' }}</button>
                            <a href="{{ route('events') }}" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                @else
                    <div class="col-sm-6">
                        <p>You have reached event limitation. Please upgrade your membership if you want more events.</p>
                        {{--<p>Go <a href="{{ route('membership') }}">here</a> to upgrade now.</p>--}}
                        <p>Or</p>
                        <p>Deactivate the existing events to create a new event.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@if (!empty($event) || $current_event < Auth::user()->event)
@section('style')
    <style type="text/css">
        .form-check-input[type=radio] {
            margin-top: 12px;
        }

        .form-group .mon, .form-group .tue, .form-group .wed, .form-group .thu,
        .form-group .fri, .form-group .sat, .form-group .sun {
            display: inline-block;
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('[name=timezone]').val(Intl.DateTimeFormat().resolvedOptions().timeZone);

            $('#daterange').daterangepicker({
                minDate: '{{ date('m/d/Y') }}',
                @if (!empty($event) && $event['start_date'] && $event['end_date'])
                    startDate: '{{ date('m/d/Y', strtotime($event['start_date'])) }}',
                    endDate: '{{ date('m/d/Y', strtotime($event['end_date'])) }}',
                @endif
            });
            @if (empty($event))
                $('#daterange').val('');
            @endif

            $('[name=time_slot]').on('change', function() {
                $('#schedule').hide();
                $('#custom').hide();
                $('#' + $(this).val()).show();
            });

            $('.apply-to').on('change', function() {
                var that = $(this), value = that.val(), val;
                if(that.prop('checked')) {
                    $('.' + value).hide();
                    that.parent().show();
                } else {
                    $('.' + value).show();
                }
                $('.form-group.' + value + ' .apply-to').each(function() {
                    val = $(this).val();
                    if ($(this).prop('checked')) {
                        that.parent().siblings('.' + val).show().find('input').prop('checked', true);
                        $(this).prop('checked', false).parent().hide();
                    }
                });
            });
        });
        function hiddenApply(week) {
            $('.' + week).hide();
            $('.apply-to').each(function() {
                if ($(this).prop('checked')) {
                    $(this).parent().show();
                }
            });
        }
        @if (Globals::$mon) hiddenApply('mon'); @endif
        @if (Globals::$tue) hiddenApply('tue'); @endif
        @if (Globals::$wed) hiddenApply('wed'); @endif
        @if (Globals::$thu) hiddenApply('thu'); @endif
        @if (Globals::$fri) hiddenApply('fri'); @endif
        @if (Globals::$sat) hiddenApply('sat'); @endif
        @if (Globals::$sun) hiddenApply('sun'); @endif
    </script>
@endsection
@endif