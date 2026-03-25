@extends('user.partials.layout')

@section('title', $app['name'].' Connection')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">{{ $app['name'] }} Connection</h4>
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
                <div class="col-sm-6">
                    <form action="{{ url()->current() }}" method="POST">
                        @csrf
                        <div class="form-group @if ($errors->has('link'))) has-error @endif">
                            <label for="link">{{ $app['name'] }} Link:<span class="required">*</span></label>
                            <input type="url" id="link" name="link" class="form-control" required
                                   value="{{ old('link', empty($app_data['app_link_'.$app['id']]) ? '' : $app_data['app_link_'.$app['id']]) }}">
                            @if ($errors->has('link'))<span class="w-100 ml-2 small error">{{ $errors->first('link') }}</span>@endif
                        </div>

                        @if ($app['id'] == 2)
                            <div class="form-group @if ($errors->has('passcode')) has-error @endif">
                                <label for="passcode">Passcode:<span class="required">*</span></label>
                                <input type="text" id="passcode" name="passcode" class="form-control" required
                                    value="{{ old('passcode', empty($app_data['app_passcode_'.$app['id']]) ? '' : $app_data['app_passcode_'.$app['id']]) }}">
                                @if ($errors->has('passcode'))<span class="w-100 ml-2 small error">{{ $errors->first('passcode') }}</span>@endif
                            </div>
                        @endif

                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('apps') }}" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection