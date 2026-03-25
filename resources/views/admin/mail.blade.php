@extends('admin.partials.layout')

@section('title', 'Apps')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Mail Template</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Mail</li>
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
                        <div class="card-header alert alert-warning">
                            <div class="row">
                                <div class="col-12">
                                    <h5><i class="fa fa-warning"></i> Note</h5>
                                    <p>Here are available words.</p>
                                    <ul class="m-0">
                                        <li>{Site Name}</li>
                                        <li>{Name}</li>
                                        <li>{Email}</li>
                                        <li>{Link}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="subject" class="col-sm-2 control-label">Mail Subject: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('subject')) has-error @endif">
                                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Mail Subject" required
                                               value="{{ old('subject', empty($mail) ? '' : $mail['subject']) }}">
                                        @if ($errors->has('subject'))<span class="w-100 ml-2 small error">{{ $errors->first('subject') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="body" class="col-sm-2 control-label">Mail Body: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('body')) has-error @endif">
                                        <textarea name="body" id="body" class="form-control" placeholder="Mail Body"
                                                  required>{{ old('body', empty($mail) ? '' : $mail['body']) }}</textarea>
                                        @if ($errors->has('body'))<span class="w-100 ml-2 small error">{{ $errors->first('body') }}</span>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary ml-2">Save</button>
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
    <script type="text/javascript">
        $(function() {
            var editor1Obj =  document.getElementById('body');
            if (editor1Obj) {
                CKEDITOR.replace('body', {
                    filebrowserUploadUrl: '',
                    filebrowserUploadMethod: 'form',
                    editorplaceholder: 'Mail Body'
                });
            }
        });
    </script>
@endsection