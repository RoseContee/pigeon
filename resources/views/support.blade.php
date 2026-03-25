@extends('layouts')

@section('title', 'Get Support')

@section('seo')
    <meta name="description" content=""/>

    <meta property="og:title" content="Get Support | PIGEON"/>
    <meta property="og:url" content="{{ route('support') }}"/>
    <meta property="og:description" content=""/>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <form action="{{ route('support') }}" method="POST">
                    @csrf
                    <h2 class="text-center">Contact us</h2>
                    <p>
                        For better understanding of Pigeon, it's functionalities, answer to frequently asked questions,
                        please visit our <a href="{{ route('knowledgebase') }}">knowledge base</a>.
                    </p>
                    @if ($error_message = session('error_message'))
                        <div class="alert alert-danger">
                            {{ $error_message }}
                        </div>
                    @endif
                    @if ($info_message = session('info_message'))
                        <div class="alert alert-success">
                            {{ $info_message }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" required
                            value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <label for="name" class="small error mb-0 font-weight-normal">{{ $errors->first('name') }}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" required
                               value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <label for="email" class="small error mb-0 font-weight-normal">{{ $errors->first('email') }}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="type">Support Type <span class="text-danger">*</span></label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="General" @if(old('type') == 'General') selected @endif>General</option>
                            <option value="Technical" @if(old('type') == 'Technical') selected @endif>Technical</option>
                            <option value="Billing" @if(old('type') == 'Billing') selected @endif>Billing</option>
                            <option value="Account Related" @if(old('type') == 'Account Related') selected @endif>Account Related</option>
                        </select>
                        @if ($errors->has('type'))
                            <label for="type" class="small error mb-0 font-weight-normal">{{ $errors->first('type') }}</label>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">Describe your issue <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control" rows="5" required
                                  placeholder="Enter description ...">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <label for="description" class="small error mb-0 font-weight-normal">{{ $errors->first('description') }}</label>
                        @endif
                    </div>
                    <button class="btn btn-primary btn-block mb-4">Send</button>
                    <p class="mb-4">
                        For more assistance or queries feel free to write us at <a href="mailto:{{ $setting['contact_email'] }}">{{ $setting['contact_email'] }}</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection