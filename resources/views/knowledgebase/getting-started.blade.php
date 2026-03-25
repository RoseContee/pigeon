@extends('layouts')

@section('title', 'Getting Started')

@section('seo')
    <meta name="description" content=""/>

    <meta property="og:title" content="Getting Started | PIGEON"/>
    <meta property="og:url" content="{{ route('getting-started') }}"/>
    <meta property="og:description" content=""/>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-black-50 mb-4">
                <a href="{{ route('knowledgebase') }}" class="text-dark">Knowledge Base</a>
                <i class="fa fa-arrow-right mx-2"></i> Getting Started with Pigeon
            </div>
            <div class="col-12">
                <h3 class="text-center mb-5">Getting Started with {{ $setting['site_name'] }}</h3>
            </div>
            <div class="col-12">
                <h5 class="mb-3 text-bold">To use Pigeon Chrome Extension</h5>
                <p>
                    Step 1: <a href="https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm">Install</a> Pigeon Chrome Extension<br>
                    Step 2: Go to LinkedIn Chat & open any message<br>
                    Step 3: Look for hyperlinked words like "meeting", "zoom", "call" in messages<br>
                    Step 4: Click right mouse on the hyperlinked word and then click on Pigeon Invite from Contextual Menu<br>
                    Step 5: Sign in with Google<br>
                    Step 6: Select a meeting platform i.e. Google Meet or Zoom (You may need to sign in & allow Pigeon to access your account from selected platform)<br>
                </p>
                <div class="text-center mb-3">
                    <img src="{{ asset('public/assets/images/pigeon_extension.jpg') }}" class="img-fluid" alt="{{ $setting['site_name'] }} Extension">
                </div>
                <p>
                    Step 7: Enter event name<br>
                    Step 8: Add or delete guests email addresses<br>
                    Step 9: Select date & time<br>
                    Step 10: Click "Send invite"<br>
                </p>
            </div>
            <div class="col-12">
                <h5 class="mb-3 text-bold">To use Pigeon Link/Scheduling URL</h5>
                <p>
                    Step 1: Sign in with Google at <a href="https://joinpigeon.com/">https://joinpigeon.com</a><br>
                    Step 2: Click <a href="https://joinpigeon.com/availability">"Pigeon Link"</a> in your Dashboard and create a personalized scheduling URL.<br>
                </p>
                <div class="text-center mb-3">
                    <img src="{{ asset('public/assets/images/pigeon_link.png') }}" class="img-fluid" alt="{{ $setting['site_name'] }} Link">
                </div>
                <p>
                    Step 3: Create your <a href="https://joinpigeon.com/schedules">Schedules</a> i.e. your availability on certain days and save it.<br>
                </p>
                <div class="text-center mb-3">
                    <img src="{{ asset('public/assets/images/schedule.jpg') }}" class="img-fluid" alt="{{ $setting['site_name'] }} Schedule">
                </div>
                <p>
                    Step 4: Create <a href="https://joinpigeon.com/events">Events</a> for users to book your time slots.<br>
                </p>
                <div class="text-center mb-3">
                    <img src="{{ asset('public/assets/images/events.png') }}" class="img-fluid" alt="{{ $setting['site_name'] }} Event">
                </div>
                <p>
                    Step 5: Share event URLs with your audience.<br>
                </p>
                <div class="text-center mb-3">
                    <img src="{{ asset('public/assets/images/share.jpg') }}" class="img-fluid" alt="{{ $setting['site_name'] }} Share">
                </div>
            </div>
        </div>
    </div>
@endsection