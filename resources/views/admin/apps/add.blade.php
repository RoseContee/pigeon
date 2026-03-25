@extends('admin.partials.layout')

@section('title', 'Apps')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ empty($app) ? 'Add' : 'Edit' }} App</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Apps</li>
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
                            <h3 class="card-title">App Info</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="name" class="col-sm-2 control-label">App Name: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('name')) has-error @endif">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="App Name" required
                                               value="{{ old('name', empty($app) ? '' : $app['name']) }}" @if (!empty($app) && $app['id'] < 3) readonly @endif>
                                        @if ($errors->has('name'))<span class="w-100 ml-2 small error">{{ $errors->first('name') }}</span>@endif
                                    </div>
                                </div>

                                @if (!empty($app['image']))
                                <div class="row">
                                    <div class="col-sm-9 offset-sm-2">
                                        <img src="{{ asset('public/uploads/'.$app['image']) }}"
                                             alt="App Image" style="width: 150px;">
                                    </div>
                                </div>
                                @endif

                                <div class="row">
                                    <label for="image" class="col-sm-2 control-label">App Image: @if (empty($app['image'])) <span class="required">*</span> @endif</label>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="image" accept="image/*"
                                                   onchange="$('#image_label').text(this.value ? this.value.split('\\').pop() : 'Choose file')"
                                                   @if (empty($app['image'])) required @endif>
                                            <label id="image_label" class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                        @if ($errors->has('image'))<span class="ml-2 small error">{{ $errors->first('image') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="active" class="col-sm-2 control-label">Active: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('active')) has-error @endif">
                                        <select name="active" id="active" class="form-control">
                                            <option value="1" @if(old('email', empty($app) ? 1 : $app['active']) == 1) selected @endif>Active</option>
                                            <option value="0" @if(old('email', empty($app) ? 1 : $app['active']) == 0) selected @endif>Deactive</option>
                                        </select>
                                        @if ($errors->has('active'))<span class="w-100 ml-2 small error">{{ $errors->first('active') }}</span>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary ml-2">Save</button>
                            <a href="{{ route('admin.apps') }}" class="btn btn-danger">Back</a>
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