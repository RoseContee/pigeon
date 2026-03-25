@extends('layouts')

@section('title', 'Knowledge Base')

@section('seo')
    <meta name="description" content=""/>

    <meta property="og:title" content="Knowledge Base | PIGEON"/>
    <meta property="og:url" content="{{ route('knowledgebase') }}"/>
    <meta property="og:description" content=""/>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mb-5">Welcome to {{ $setting['site_name'] }} Knowledge Base!</h3>
            </div>
            <div class="col-12">
                <a href="{{ route('getting-started') }}" class="card">
                    <h5 class="card-body mb-0">
                        Getting Started with {{ $setting['site_name'] }}
                    </h5>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('connecting-zoom') }}" class="card">
                    <h5 class="card-body mb-0">
                        Connecting Zoom
                    </h5>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('faq') }}" class="card">
                    <h5 class="card-body mb-0">
                        Frequently asked questions
                    </h5>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('support') }}" class="card">
                    <h5 class="card-body mb-0">
                        Contact support
                    </h5>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('cookies-policy') }}" class="card">
                    <h5 class="card-body mb-0">
                        Cookies Policy
                    </h5>
                </a>
            </div>
        </div>
    </div>
@endsection