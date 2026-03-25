@extends('admin.partials.layout')

@section('title', 'Setting')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Setting</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Setting</li>
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
                        <input type="hidden" name="type" value="general">
                        <div class="card-header">
                            <h3 class="card-title">Site Setting</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="site_name" class="col-sm-2 control-label">Site Name: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('site_name')) has-error @endif">
                                        <input type="text" name="site_name" id="site_name" class="form-control" placeholder="Site Name" required
                                               value="{{ old('site_name', $setting['site_name']) }}">
                                        <span class="w-100 ml-2 small">Site name cannot include any space.</span>
                                        @if ($errors->has('site_name'))<span class="w-100 ml-2 small error">{{ $errors->first('site_name') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="site_url" class="col-sm-2 control-label">Site URL: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('site_url')) has-error @endif">
                                        <input type="url" name="site_url" id="site_url" class="form-control" placeholder="Site URL" required
                                               value="{{ old('site_url', $setting['site_url']) }}">
                                        @if ($errors->has('site_url'))<span class="w-100 ml-2 small error">{{ $errors->first('site_url') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="site_logo" class="col-sm-2 control-label">Site Logo: @if (empty($setting['site_logo']))<span class="required">*</span>@endif</label>

                                    <div class="col-sm-9 @if ($errors->has('site_logo')) has-error @endif">
                                        @if (!empty($setting['site_logo']))
                                            <div class="row">
                                                <div class="col-12">
                                                    <img src="{{ asset('public/'.$setting['site_logo']) }}" width="100" class="img-circle">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="site_logo" class="custom-file-input" id="site_logo" accept="image/*" @if(empty($setting['site_logo'])) required @endif
                                                    onchange="$('#logo_label').text(this.value ? this.value.split('\\').pop() : 'Choose file')">
                                                <label id="logo_label" class="custom-file-label" for="site_logo">Choose file</label>
                                            </div>
                                        </div>
                                        @if ($errors->has('site_logo'))<span class="w-100 ml-2 small error">{{ $errors->first('site_logo') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="favicon" class="col-sm-2 control-label">Favicon: @if (empty($setting['favicon']))<span class="required">*</span>@endif</label>

                                    <div class="col-sm-9 @if ($errors->has('favicon')) has-error @endif">
                                        @if (!empty($setting['favicon']))
                                            <div class="row">
                                                <div class="col-12">
                                                    <img src="{{ asset('public/'.$setting['favicon']) }}" width="50" class="img-circle">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="favicon" class="custom-file-input" id="favicon" accept="image/*" @if(empty($setting['favicon'])) required @endif
                                                    onchange="$('#favicon_label').text(this.value ? this.value.split('\\').pop() : 'Choose file')">
                                                <label id="favicon_label" class="custom-file-label" for="favicon">Choose file</label>
                                            </div>
                                        </div>
                                        @if ($errors->has('favicon'))<span class="w-100 ml-2 small error">{{ $errors->first('favicon') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="contact_email" class="col-sm-2 control-label">Contact Email: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('contact_email')) has-error @endif">
                                        <input type="email" name="contact_email" id="contact_email" class="form-control" placeholder="Contact Email" required
                                               value="{{ old('contact_email', $setting['contact_email']) }}">
                                        @if ($errors->has('contact_email'))<span class="w-100 ml-2 small error">{{ $errors->first('contact_email') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="how_video" class="col-sm-2 control-label">How it works video URL: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('how_video')) has-error @endif">
                                        <input type="url" name="how_video" id="how_video" class="form-control" placeholder="How it works video URL" required
                                               value="{{ old('how_video', empty($setting['how_video'])) ? '' : $setting['how_video'] }}">
                                        @if ($errors->has('how_video'))<span class="w-100 ml-2 small error">{{ $errors->first('how_video') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="facebook_link" class="col-sm-2 control-label">Facebook Link: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('facebook_link')) has-error @endif">
                                        <input type="url" name="facebook_link" id="facebook_link" class="form-control" placeholder="Facebook Link" required
                                               value="{{ old('facebook_link', $setting['facebook_link']) }}">
                                        @if ($errors->has('facebook_link'))<span class="w-100 ml-2 small error">{{ $errors->first('facebook_link') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="twitter_link" class="col-sm-2 control-label">Twitter Link: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('twitter_link')) has-error @endif">
                                        <input type="url" name="twitter_link" id="twitter_link" class="form-control" placeholder="Twitter Link" required
                                               value="{{ old('twitter_link', $setting['twitter_link']) }}">
                                        @if ($errors->has('twitter_link'))<span class="w-100 ml-2 small error">{{ $errors->first('twitter_link') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="linkedin_link" class="col-sm-2 control-label">LinkedIn Link: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('linkedin_link')) has-error @endif">
                                        <input type="url" name="linkedin_link" id="linkedin_link" class="form-control" placeholder="LinkedIn Link" required
                                               value="{{ old('linkedin_link', $setting['linkedin_link']) }}">
                                        @if ($errors->has('linkedin_link'))<span class="w-100 ml-2 small error">{{ $errors->first('linkedin_link') }}</span>@endif
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

                <div class="card">
                    <form action="{{ url()->current() }}" class="form-horizontal" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="seo">
                        <div class="card-header">
                            <h3 class="card-title">SEO Setting</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="meta_title" class="col-sm-2 control-label">Meta Title: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('meta_title')) has-error @endif">
                                        <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Meta Title" required
                                               value="{{ old('meta_title', $setting['meta_title']) }}">
                                        @if ($errors->has('meta_title'))<span class="w-100 ml-2 small error">{{ $errors->first('meta_title') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="meta_keywords" class="col-sm-2 control-label">Meta Keywords: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('meta_keywords')) has-error @endif">
                                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" placeholder="Meta Keywords" required
                                               value="{{ old('meta_keywords', $setting['meta_keywords']) }}">
                                        @if ($errors->has('meta_keywords'))<span class="w-100 ml-2 small error">{{ $errors->first('meta_keywords') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="meta_description" class="col-sm-2 control-label">Meta Description: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('meta_description')) has-error @endif">
                                        <input type="text" name="meta_description" id="meta_description" class="form-control" placeholder="Meta Description" required
                                               value="{{ old('meta_description', $setting['meta_description']) }}">
                                        @if ($errors->has('meta_description'))<span class="w-100 ml-2 small error">{{ $errors->first('meta_description') }}</span>@endif
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

                <div class="card">
                    <form action="{{ url()->current() }}" class="form-horizontal" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="mail">
                        <div class="card-header">
                            <h3 class="card-title">Mail Setting</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="mail_driver" class="col-sm-2 control-label">Mail Driver: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('mail_driver')) has-error @endif">
                                        <input type="text" name="mail_driver" id="mail_driver" class="form-control" placeholder="Mail Driver" required
                                               value="{{ old('mail_driver', $setting['mail_driver']) }}">
                                        @if ($errors->has('mail_driver'))<span class="w-100 ml-2 small error">{{ $errors->first('mail_driver') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="mail_host" class="col-sm-2 control-label">Mail Host: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('mail_host')) has-error @endif">
                                        <input type="text" name="mail_host" id="mail_host" class="form-control" placeholder="Mail Host" required
                                               value="{{ old('mail_host', $setting['mail_host']) }}">
                                        @if ($errors->has('mail_host'))<span class="w-100 ml-2 small error">{{ $errors->first('mail_host') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="mail_port" class="col-sm-2 control-label">Mail Port: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('mail_port')) has-error @endif">
                                        <input type="text" name="mail_port" id="mail_port" class="form-control" placeholder="Mail Port" required
                                               value="{{ old('mail_port', $setting['mail_port']) }}">
                                        @if ($errors->has('mail_port'))<span class="w-100 ml-2 small error">{{ $errors->first('mail_port') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="mail_username" class="col-sm-2 control-label">Mail Username: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('mail_username')) has-error @endif">
                                        <input type="text" name="mail_username" id="mail_username" class="form-control" placeholder="Mail Username" required
                                               value="{{ old('mail_username', $setting['mail_username']) }}">
                                        @if ($errors->has('mail_username'))<span class="w-100 ml-2 small error">{{ $errors->first('mail_username') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="mail_password" class="col-sm-2 control-label">Mail Password: </label>

                                    <div class="col-sm-9 @if ($errors->has('mail_password')) has-error @endif">
                                        <input type="text" name="mail_password" id="mail_password" class="form-control" placeholder="Mail Password (leave blank if do not want to change current password)"
                                               >
                                        @if ($errors->has('mail_password'))<span class="w-100 ml-2 small error">{{ $errors->first('mail_password') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="mail_encryption" class="col-sm-2 control-label">Mail Encryption: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('mail_encryption')) has-error @endif">
                                        <input type="text" name="mail_encryption" id="mail_encryption" class="form-control" placeholder="Mail Encryption"
                                               value="{{ old('mail_encryption', $setting['mail_encryption']) }}">
                                        @if ($errors->has('mail_encryption'))<span class="w-100 ml-2 small error">{{ $errors->first('mail_encryption') }}</span>@endif
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

                <div class="card">
                    <form action="{{ url()->current() }}" class="form-horizontal" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="google">
                        <div class="card-header">
                            <h3 class="card-title">Google Setting</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="google_client_id" class="col-sm-2 control-label">Google Client ID: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('google_client_id')) has-error @endif">
                                        <input type="text" name="google_client_id" id="google_client_id" class="form-control" placeholder="Google Client ID" required
                                               value="{{ old('google_client_id', $setting['google_client_id']) }}">
                                        @if ($errors->has('google_client_id'))<span class="w-100 ml-2 small error">{{ $errors->first('google_client_id') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="google_client_secret" class="col-sm-2 control-label">Google Client Secret: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('google_client_secret')) has-error @endif">
                                        <input type="text" name="google_client_secret" id="google_client_secret" class="form-control" placeholder="Google Client Secret" required
                                               value="{{ old('google_client_secret', $setting['google_client_secret']) }}">
                                        @if ($errors->has('google_client_secret'))<span class="w-100 ml-2 small error">{{ $errors->first('google_client_secret') }}</span>@endif
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

                {{--<div class="card">
                    <form action="{{ url()->current() }}" class="form-horizontal" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="linkedin">
                        <div class="card-header">
                            <h3 class="card-title">LinkedIn Setting</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <label for="linkedin_client_id" class="col-sm-2 control-label">LinkedIn Client ID: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('linkedin_client_id')) has-error @endif">
                                        <input type="text" name="linkedin_client_id" id="linkedin_client_id" class="form-control" placeholder="LinkedIn Client ID" required
                                               value="{{ old('linkedin_client_id', $setting['linkedin_client_id']) }}">
                                        @if ($errors->has('linkedin_client_id'))<span class="w-100 ml-2 small error">{{ $errors->first('linkedin_client_id') }}</span>@endif
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="linkedin_client_secret" class="col-sm-2 control-label">LinkedIn Client Secret: <span class="required">*</span></label>

                                    <div class="col-sm-9 @if ($errors->has('linkedin_client_secret')) has-error @endif">
                                        <input type="text" name="linkedin_client_secret" id="linkedin_client_secret" class="form-control" placeholder="LinkedIn Client Secret" required
                                               value="{{ old('linkedin_client_secret', $setting['linkedin_client_secret']) }}">
                                        @if ($errors->has('linkedin_client_secret'))<span class="w-100 ml-2 small error">{{ $errors->first('linkedin_client_secret') }}</span>@endif
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
                <!-- /.card -->--}}
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