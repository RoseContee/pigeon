@extends('layouts')

@section('title', 'Connecting Zoom')

@section('seo')
    <meta name="description" content=""/>

    <meta property="og:title" content="Connecting Zoom | PIGEON"/>
    <meta property="og:url" content="{{ route('connecting-zoom') }}"/>
    <meta property="og:description" content=""/>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-black-50 mb-4">
                <a href="{{ route('knowledgebase') }}" class="text-dark">Knowledge Base</a>
                <i class="fa fa-arrow-right mx-2"></i> Connecting Zoom
            </div>
            <div class="col-12">
                <h5 class="mb-3 text-bold">Connecting Zoom</h5>
                <p>
                    1. When you are scheduling a meeting via Pigeon Chrome Extension you need to select Zoom as a meeting platform.<br>
                </p>
                <div class="text-center mb-3">
                    <img src="{{ asset('public/assets/images/zoom_selected.jpg') }}" class="img-fluid" alt="Zoom Selected">
                </div>
                <p>
                    2. Once selected, you need to allow Pigeon to access your Zoom profile in order to create a unique
                    video conference link for every meeting.<br>
                    3. When a new meeting is scheduled with Pigeon, a Zoom video conference link is automatically created
                    and added to the meeting details, calendar and email notifications.<br>
                </p>
            </div>
            <div class="col-12">
                <h5 class="mb-3 text-bold">Troubleshooting</h5>
                <p>
                    Note that if your Zoom links are not generated it's because the Zoom API has a daily rate limit of
                    100 requests per day. Therefore, only 100 meetings can be created within a 24-hour window for a user.<br>
                </p>
            </div>
        </div>
    </div>
@endsection