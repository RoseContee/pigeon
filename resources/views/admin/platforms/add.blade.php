@extends('admin.partials.layout')

@section('title', 'Platforms')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ empty($platform) ? 'Add' : 'Edit' }} Platform</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Platforms</li>
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
                    <form action="{{ url()->current() }}" class="form-horizontal" method="POST">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Platform Info</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="name" class="col-sm-2 control-label">Platform Name: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('name')) has-error @endif">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Platform Name" required
                                               value="{{ old('name', empty($platform) ? '' : $platform['name']) }}" @if (!empty($platform) && $platform['id'] == 1) readonly @endif>
                                        @if ($errors->has('name'))<span class="w-100 ml-2 small error">{{ $errors->first('name') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="url" class="col-sm-2 control-label">Platform URL: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('url')) has-error @endif">
                                        <input type="url" name="url" id="url" class="form-control" placeholder="Platform URL" required
                                               value="{{ old('url', empty($platform) ? '' : $platform['url']) }}" @if (!empty($platform) && $platform['id'] == 1) readonly @endif>
                                        @if ($errors->has('url'))<span class="w-100 ml-2 small error">{{ $errors->first('url') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="active" class="col-sm-2 control-label">Active: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('active')) has-error @endif">
                                        <select name="active" id="active" class="form-control">
                                            <option value="1" @if(old('active', empty($platform) ? 1 : $platform['active']) == 1) selected @endif>Active</option>
                                            <option value="0" @if(old('active', empty($platform) ? 1 : $platform['active']) == 0) selected @endif>Deactive</option>
                                        </select>
                                        @if ($errors->has('active'))<span class="w-100 ml-2 small error">{{ $errors->first('active') }}</span>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary ml-2">Save</button>
                            <a href="{{ route('admin.platforms') }}" class="btn btn-danger">Back</a>
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