@extends('user.partials.layout')

@section('title', 'My Profile')

@section('content')
    <div class="content my-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <form action="{{ route('profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center">
                            <img src="{{ empty(Auth::user()->avatar) ? asset('public/assets/images/default-user.png') : Auth::user()->avatar }}"
                                 alt="User Avatar" class="img-circle elevation-1" style="width: 150px;">
                        </div>
                        <div class="input-group my-3">
                            <div class="custom-file">
                                <input type="file" name="avatar" class="custom-file-input" id="avatar" accept="image/*"
                                onchange="$('#avatar_label').text(this.value ? this.value.split('\\').pop() : 'Choose file')">
                                <label id="avatar_label" class="custom-file-label" for="avatar">Choose file</label>
                            </div>
                        </div>
                        @if ($errors->has('avatar'))<span class="ml-2 small error">{{ $errors->first('avatar') }}</span>@endif

                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">Name: <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" required
                                   value="{{ old('name', Auth::user()->name) }}">
                            @if ($errors->has('name'))<span class="ml-2 small error">{{ $errors->first('name') }}</span>@endif
                        </div>

                        <div class="form-group @if ($errors->has('headline')) has-error @endif">
                            <label for="headline">Headline of LinkedIn:</label>
                            <input type="text" id="headline" name="headline" class="form-control"
                                   value="{{ old('headline', empty($user_setting['headline']) ? '' : $user_setting['headline']) }}">
                            @if ($errors->has('headline'))<span class="ml-2 small error">{{ $errors->first('headline') }}</span>@endif
                        </div>

                        <div class="form-group @if ($errors->has('position')) has-error @endif">
                            <label for="position">Position of LinkedIn:</label>
                            <input type="text" id="position" name="position" class="form-control"
                                   value="{{ old('position', empty($user_setting['position']) ? '' : $user_setting['position']) }}">
                            @if ($errors->has('position'))<span class="ml-2 small error">{{ $errors->first('position') }}</span>@endif
                        </div>

                        <div class="form-group @if ($errors->has('email')) has-error @endif">
                            <label for="email">Primary Email address (Account email): <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" required
                                   value="{{ old('email', Auth::user()->email) }}">
                            @if ($errors->has('email'))<span class="ml-2 small error">{{ $errors->first('email') }}</span>@endif
                        </div>

                        <div class="form-group @if ($errors->has('secondary_email')) has-error @endif">
                            <label for="secondary_email">Alternate Email address:</label>
                            <input type="email" id="secondary_email" name="secondary_email" class="form-control"
                                   value="{{ old('secondary_email', empty($user_setting['secondary_email']) ? '' : $user_setting['secondary_email']) }}">
                            @if ($errors->has('secondary_email'))<span class="ml-2 small error">{{ $errors->first('secondary_email') }}</span>@endif
                        </div>

                        <button type="submit" class="btn btn-primary">Save & Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('script')
@endsection