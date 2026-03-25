@extends('admin.partials.layout')

@section('title', 'Memberships')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ empty($membership) ? 'Add' : 'Edit' }} Membership</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Memberships</li>
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
                            <h3 class="card-title">Membership Info</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="package" class="col-sm-2 control-label">Package: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('package')) has-error @endif">
                                        <select name="package" id="package" class="form-control">
                                            @foreach ($packages as $package)
                                                <option value="{{ $package['id'] }}"
                                                        @if(old('package', empty($membership) ? '' : $membership['membership_package_id']) == $package['id']) selected @endif>{{ $package['name'] }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('package'))<span class="w-100 ml-2 small error">{{ $errors->first('package') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="name" class="col-sm-2 control-label">Membership Name: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('name')) has-error @endif">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Membership Name" required
                                               value="{{ old('name', empty($membership) ? '' : $membership['name']) }}">
                                        @if ($errors->has('name'))<span class="w-100 ml-2 small error">{{ $errors->first('name') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="price" class="col-sm-2 control-label">Membership Price: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('price')) has-error @endif">
                                        <input type="number" name="price" id="price" class="form-control" placeholder="Membership Price" required
                                               value="{{ old('price', empty($membership) ? '' : $membership['price']) }}">
                                        @if ($errors->has('price'))<span class="w-100 ml-2 small error">{{ $errors->first('price') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="limitation" class="col-sm-2 control-label">Limitation: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('limitation')) has-error @endif">
                                        <input type="number" name="limitation" id="limitation" class="form-control" placeholder="Limitation" required
                                               value="{{ old('limitation', empty($membership) ? '' : $membership['limitation']) }}">
                                        @if ($errors->has('limitation'))<span class="w-100 ml-2 small error">{{ $errors->first('limitation') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="event" class="col-sm-2 control-label">Event Number: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('event')) has-error @endif">
                                        <input type="number" name="event" id="event" class="form-control" placeholder="Event Number" required
                                               value="{{ old('event', empty($membership) ? '' : $membership['event']) }}">
                                        @if ($errors->has('event'))<span class="w-100 ml-2 small error">{{ $errors->first('event') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="schedule" class="col-sm-2 control-label">Schedule Number: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('schedule')) has-error @endif">
                                        <input type="number" name="schedule" id="schedule" class="form-control" placeholder="Schedule Number" required
                                               value="{{ old('schedule', empty($membership) ? '' : $membership['schedule']) }}">
                                        @if ($errors->has('schedule'))<span class="w-100 ml-2 small error">{{ $errors->first('schedule') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="description" class="col-sm-2 control-label">Description: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('description')) has-error @endif">
                                        <textarea id="description" name="description" class="form-control" rows="10"
                                            placeholder="Input Membership description...">{{ old('description', empty($membership) ? '' : $membership['description']) }}</textarea>
                                        @if ($errors->has('description'))<span class="w-100 ml-2 small error">{{ $errors->first('description') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="active" class="col-sm-2 control-label">Active: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('active')) has-error @endif">
                                        <select name="active" id="active" class="form-control">
                                            <option value="1" @if(old('active', empty($membership) ? 1 : $membership['active']) == 1) selected @endif>Active</option>
                                            <option value="0" @if(old('active', empty($membership) ? 1 : $membership['active']) == 0) selected @endif>Deactive</option>
                                        </select>
                                        @if ($errors->has('active'))<span class="w-100 ml-2 small error">{{ $errors->first('active') }}</span>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary ml-2">Save</button>
                            <a href="{{ route('admin.memberships') }}" class="btn btn-danger">Back</a>
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