@extends('user.partials.layout')

@section('title', empty($guest) ? 'Add New Guest' : 'Edit Guest')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">{{ empty($guest) ? 'Add New Guest' : 'Edit Guest' }}</h4>
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
                        <div class="form-group @if ($errors->has('email') || ($error = session('email_error'))) has-error @endif">
                            <label for="email">Email address:<span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" required
                                   value="{{ old('email', empty($guest) ? '' : $guest['email']) }}">
                            @if ($errors->has('email'))<span class="w-100 ml-2 small error">{{ $errors->first('email') }}</span>@endif
                            @if (!empty($error))<span class="w-100 ml-2 small error">{{ $error }}</span>@endif
                        </div>

                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name', empty($guest) ? '' : $guest['name']) }}">
                            @if ($errors->has('name'))<span class="w-100 ml-2 small error">{{ $errors->first('name') }}</span>@endif
                        </div>

                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('guests') }}" class="btn btn-danger">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection