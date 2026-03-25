@extends('admin.partials.layout')

@section('title', 'Users')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $user['email'] }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                            <h3 class="card-title">User Info</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="name" class="col-sm-2 control-label">User Name: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('name')) has-error @endif">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="User Name" required
                                               value="{{ old('name', empty($user) ? '' : $user['name']) }}">
                                        @if ($errors->has('name'))<span class="w-100 ml-2 small error">{{ $errors->first('name') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="email" class="col-sm-2 control-label">User Email: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('email')) has-error @endif">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="User Email" required
                                               value="{{ old('email', empty($user) ? '' : $user['email']) }}">
                                        @if ($errors->has('email'))<span class="w-100 ml-2 small error">{{ $errors->first('email') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="membership" class="col-sm-2 control-label">Membership: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('membership')) has-error @endif">
                                        <select name="membership" id="membership" class="form-control">
                                            @foreach ($memberships as $membership)
                                                <option value="{{ $membership['id'] }}"
                                                        @if(old('membership', empty($user) ? 1 : $user['membership_id']) == $membership['id']) selected @endif>{{ $membership['name'] }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('membership'))<span class="w-100 ml-2 small error">{{ $errors->first('membership') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="active" class="col-sm-2 control-label">Active: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('active')) has-error @endif">
                                        <select name="active" id="active" class="form-control">
                                            <option value="1" @if(old('active', empty($user) ? 1 : $user['active']) == 1) selected @endif>Active</option>
                                            <option value="0" @if(old('active', empty($user) ? 1 : $user['active']) == 0) selected @endif>Deactive</option>
                                        </select>
                                        @if ($errors->has('active'))<span class="w-100 ml-2 small error">{{ $errors->first('active') }}</span>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary ml-2">Save</button>
                            <a href="{{ route('admin.users') }}" class="btn btn-danger">Back</a>
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