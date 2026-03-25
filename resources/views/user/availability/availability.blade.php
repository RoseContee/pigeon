@extends('user.partials.layout')

@section('title', 'Availability')

@section('content')
    <div class="content my-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <form action="{{ route('availability') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-3 mb-0">
                            <label for="link">Personal Link: <span class="required">*</span></label>
                            <div class="input-group">
                                <label for="link" class="input-group-prepend mb-0">
                                    <span class="input-group-text pr-1">{{ route('index') }}/</span>
                                </label>
                                <input type="text" id="link" name="link" class="form-control px-1" required
                                       value="{{ old('link', $link) }}">
                            </div>
                            @if ($error = session('error') || $errors->has('link'))
                                <label for="link" class="ml-2 small error mb-0 font-weight-normal">{{ $error ?: $errors->first('link') }}</label>
                            @endif
                        </div>
                        <div id="suggestions"></div>
                        <button type="submit" id="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style type="text/css">
        #link {
            text-transform: lowercase;
        }
    </style>
@endsection

@section('script')
    <script type="application/javascript">
        $(function() {
            $('#link').on('keypress, keydown', function(e) {
                if (e.keyCode == 32) return false;
                $('#submit').attr('disabled', true);
                $('#suggestions').html('');
            }).on('change', function() {
                var link = $(this).val();
                if (link) {
                    $.ajax({
                        method: 'POST',
                        url: '{{ route('check-availability') }}',
                        data: {
                            link: link
                        },
                        success: function (data) {
                            $('#suggestions').html(data.suggestions);
                            if (data.available) $('#submit').removeAttr('disabled');
                            else $('#submit').attr('disabled', true);
                        },
                        error: function (data) {
                            location.reload(true);
                        }
                    });
                }
            });
        });
    </script>
@endsection