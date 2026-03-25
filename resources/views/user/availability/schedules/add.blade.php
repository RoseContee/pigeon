@extends('user.partials.layout')

@section('title', 'My Schedule')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">{{ empty($schedule) ? 'New Schedule' : 'Edit Schedule('.$schedule['name'].')' }}</h4>
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
                <div class="col-xl-6 col-lg-8">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">Name: <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Regular Consulting Schedule"
                                   value="{{ old('name', empty($schedule) ? '' : $schedule['name']) }}" required>
                            @if ($errors->has('name'))<span class="ml-2 small error">{{ $errors->first('name') }}</span>@endif
                        </div>

                        <div class="form-group mb-0 @if ($errors->has('mon')) has-error @endif">
                            <label>Monday: <span class="required">*</span></label>
                            @include('user.partials.availability.time-slots', ['week' => 'mon', 'item' => $schedule])
                            @if ($errors->has('mon'))<span class="ml-2 small error">{{ $errors->first('mon') }}</span>@endif
                        </div>
                        @include('user.partials.availability.apply-to', ['week' => 'mon', 'item' => $schedule])

                        <div class="form-group mb-0 @if ($errors->has('tue')) has-error @endif tue">
                            <label>Tuesday: <span class="required">*</span></label>
                            @include('user.partials.availability.time-slots', ['week' => 'tue', 'item' => $schedule])
                            @if ($errors->has('tue'))<span class="ml-2 small error">{{ $errors->first('tue') }}</span>@endif
                        </div>
                        @include('user.partials.availability.apply-to', ['week' => 'tue', 'item' => $schedule])

                        <div class="form-group mb-0 @if ($errors->has('wed')) has-error @endif wed">
                            <label>Wednesday: <span class="required">*</span></label>
                            @include('user.partials.availability.time-slots', ['week' => 'wed', 'item' => $schedule])
                            @if ($errors->has('wed'))<span class="ml-2 small error">{{ $errors->first('wed') }}</span>@endif
                        </div>
                        @include('user.partials.availability.apply-to', ['week' => 'wed', 'item' => $schedule])

                        <div class="form-group mb-0 @if ($errors->has('thu')) has-error @endif thu">
                            <label>Thursday: <span class="required">*</span></label>
                            @include('user.partials.availability.time-slots', ['week' => 'thu', 'item' => $schedule])
                            @if ($errors->has('thu'))<span class="ml-2 small error">{{ $errors->first('thu') }}</span>@endif
                        </div>
                        @include('user.partials.availability.apply-to', ['week' => 'thu', 'item' => $schedule])

                        <div class="form-group @if ($errors->has('fri')) has-error @endif fri">
                            <label>Friday: <span class="required">*</span></label>
                            @include('user.partials.availability.time-slots', ['week' => 'fri', 'item' => $schedule])
                            @if ($errors->has('fri'))<span class="ml-2 small error">{{ $errors->first('fri') }}</span>@endif
                        </div>
                        @include('user.partials.availability.apply-to', ['week' => 'fri', 'item' => $schedule])

                        <div class="form-group @if ($errors->has('sat')) has-error @endif sat">
                            <label>Saturday: <span class="required">*</span></label>
                            @include('user.partials.availability.time-slots', ['week' => 'sat', 'item' => $schedule])
                            @if ($errors->has('sat'))<span class="ml-2 small error">{{ $errors->first('sat') }}</span>@endif
                        </div>
                        @include('user.partials.availability.apply-to', ['week' => 'sat', 'item' => $schedule])

                        <div class="form-group @if ($errors->has('sun')) has-error @endif sun">
                            <label>Sunday: <span class="required">*</span></label>
                            @include('user.partials.availability.time-slots', ['week' => 'sun', 'item' => $schedule])
                            @if ($errors->has('sun'))<span class="ml-2 small error">{{ $errors->first('sun') }}</span>@endif
                        </div>

                        <div class="form-group @if ($errors->has('status')) has-error @endif">
                            <label for="status">Status: </label>
                            <select id="status" name="status" class="form-control">
                                <option value="0" @if (old('status', empty($schedule) ? 0 : $schedule['active']) == 0) selected @endif>Deactive</option>
                                <option value="1" @if (old('status', empty($schedule) ? 0 : $schedule['active']) == 1) selected @endif>Active</option>
                            </select>
                            @if ($errors->has('status'))<span class="ml-2 small error">{{ $errors->first('status') }}</span>@endif
                        </div>

                        <button type="submit" class="btn btn-primary">{{ empty($schedule) ? 'Save' : 'Update' }}</button>
                        <a href="{{ route('schedules') }}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style type="text/css">
        .form-group .mon, .form-group .tue, .form-group .wed, .form-group .thu,
        .form-group .fri, .form-group .sat, .form-group .sun {
            display: inline-block;
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('.apply-to').on('change', function() {
                var that = $(this), week = that.val(), val;
                if(that.prop('checked')) {
                    $('.' + week).hide();
                    that.parent().show();
                } else {
                    $('.' + week).show();
                }
                $('.form-group.' + week + ' .apply-to').each(function() {
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