@extends('admin.partials.layout')

@section('title', 'Profile')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        @include('admin.partials.messages')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ url()->current() }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Account Setting</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="email" class="col-sm-2 control-label">Email: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('email')) has-error @endif">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required
                                               value="{{ old('email', Auth::guard('admin')->user()->email) }}">
                                        @if ($errors->has('email'))<span class="w-100 ml-2 small error">{{ $errors->first('email') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="password" class="col-sm-2 control-label">Password: </label>

                                    <div class="col-sm-9 @if ($errors->has('password')) has-error @endif">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                        @if ($errors->has('password'))<span class="w-100 ml-2 small error">{{ $errors->first('password') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="password_confirmation" class="col-sm-2 control-label">Confirm Password: </label>

                                    <div class="col-sm-9 @if ($errors->has('password_confirmation')) has-error @endif">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
                                        @if ($errors->has('password_confirmation'))<span class="w-100 ml-2 small error">{{ $errors->first('password_confirmation') }}</span>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary ml-2">Save</button>
                            <a href="{{ route('admin') }}" class="btn btn-danger">Back</a>
                        </div>
                        <!-- /.card-footer -->
                    </form>
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
@endsection