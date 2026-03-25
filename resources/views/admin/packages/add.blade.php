@extends('admin.partials.layout')

@section('title', 'Packages')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ empty($package) ? 'Add' : 'Edit' }} Package</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Packages</li>
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
                            <h3 class="card-title">Package Info</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="name" class="col-sm-2 control-label">Package Name: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('name')) has-error @endif">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Package Name" required
                                               value="{{ old('name', empty($package) ? '' : $package['name']) }}">
                                        @if ($errors->has('name'))<span class="w-100 ml-2 small error">{{ $errors->first('name') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="period" class="col-sm-2 control-label">Package Period: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('period')) has-error @endif">
                                        <input type="number" name="period" id="period" class="form-control" placeholder="Package Period" required
                                               value="{{ old('period', empty($package) ? '' : $package['period']) }}">
                                        @if ($errors->has('period'))<span class="w-100 ml-2 small error">{{ $errors->first('period') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="unit" class="col-sm-2 control-label">Unit: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('unit')) has-error @endif">
                                        <select name="unit" id="unit" class="form-control">
                                            <option value="month" @if(old('month', empty($package) ? 'month' : $package['unit']) == 'month') selected @endif>Monthly</option>
                                            <option value="year" @if(old('year', empty($package) ? 'month' : $package['unit']) == 'year') selected @endif>Yearly</option>
                                        </select>
                                        @if ($errors->has('unit'))<span class="w-100 ml-2 small error">{{ $errors->first('unit') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="discount" class="col-sm-2 control-label">Package Discount(%): <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('discount')) has-error @endif">
                                        <input type="number" name="discount" id="discount" class="form-control" placeholder="Package Discount" required
                                               value="{{ old('discount', empty($package) ? '' : $package['discount']) }}">
                                        @if ($errors->has('discount'))<span class="w-100 ml-2 small error">{{ $errors->first('discount') }}</span>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary ml-2">Save</button>
                            <a href="{{ route('admin.packages') }}" class="btn btn-danger">Back</a>
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