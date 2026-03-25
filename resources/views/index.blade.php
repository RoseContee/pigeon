@extends('layouts')

@section('title', $setting['meta_title'])

@section('seo')
    <meta name="keywords" content="{{ $setting['meta_keywords'] }}"/>
    <meta name="description" content="{{ $setting['meta_description'] }}"/>

    <meta property="og:title" content="{{ $setting['meta_title'] }}"/>
    <meta property="og:url" content="{{ $setting['site_url'] }}"/>
    <meta property="og:description" content="{{ $setting['meta_description'] }}"/>
@endsection

@section('style')
    <style type="text/css">
    </style>
@endsection

@section('content')
    <div class="container text-center">
        <div class="row">
            <div class="col-12 pt-5">
                <h1 class="h1 text-capitalize font-weight-bold text-regal-blue pt-5">Schedule Video Meetings <br> With Prospects In Just 15 Seconds.</h1>
            </div>
            <div class="col-lg-8 offset-lg-2 pt-2">
                <h4 class="h4 text-capitalize">A chrome extension that allows you to book video calls directly from linkedin chat</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6 text-md-right py-1">
                <a href="https://chrome.google.com/webstore/detail/pigeon/adlljmlbangmeenndganepfkilcdihnm" target="_blank" class="btn btn-primary bg-regal-blue">Add to Chrome - It's free</a>
            </div>
            <div class="col-md-6 text-md-left py-1">
                <a href="#" data-toggle="modal" data-target="#how-it-works-modal" class="btn btn-default bg-white btn-how-works"><i class="fa fa-play mr-3"></i> See how it works</a>
            </div>
        </div>
        <div class="py-4 py-md-5"></div>
        <div class="row">
            <div class="col-md-4 pl-lg-0 pr-lg-5 py-3 pt-md-5">
                <div class="card">
                    <div class="card-body">
                        <div style="margin-top: -55px;">
                            <div class="d-inline-block bg-white border img-circle p-3"><i class="fa fa-download fa-2x"></i></div>
                        </div>
                        <h5>Download & Install</h5>
                        <p>Download & Install {{ $setting['site_name'] }} extension from Chrome Web Store</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 px-lg-4 py-3 pt-md-5">
                <div class="card">
                    <div class="card-body">
                        <div style="margin-top: -55px;">
                            <div class="d-inline-block bg-white border img-circle p-3"><i class="fa fa-video-camera fa-2x"></i></div>
                        </div>
                        <h5>Add Meeting Platforms</h5>
                        <p>Connect your preferred meeting platforms from available apps</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 pl-lg-5 pr-lg-0 py-3 pt-md-5">
                <div class="card">
                    <div class="card-body">
                        <div style="margin-top: -55px;">
                            <div class="d-inline-block bg-white border img-circle p-3"><i class="fa fa-paper-plane fa-2x"></i></div>
                        </div>
                        <h5>Send Invites</h5>
                        <p>Check for schedules and book a meeting in 15 seconds</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wave bg-white py-5">
        <div class="container text-center pb-3">
            <div class="row">
                <div class="col-12">
                    <h3 class="h3 font-weight-bold">Feature</h3>
                </div>
            </div>
            <div class="row mt-5 mb-3">
                <div class="col-lg-1"></div>
                <div class="col-lg-5 col-md-6 pl-md-0 pr-md-3">
                    <div class="card bg-white-pink">
                        <div class="card-body">
                            <div class="d-inline-block bg-misty-pink img-circle p-3">
                                <i class="fa fa-bookmark fa-2x mx-1"></i>
                            </div>
                            <h4 class="text-capitalize mt-4">Book Video Meeting In Just 15 Seconds</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 pl-md-3 pr-md-0">
                    <div class="card bg-white-blue">
                        <div class="card-body">
                            <div class="d-inline-block bg-misty-blue img-circle p-3">
                                <i class="fa fa-plus-square fa-2x mx-1"></i>
                            </div>
                            <h4 class="text-capitalize mt-4">Add Guests Email Automatically And/Or Manually From Linkedin Chat</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1"></div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-1"></div>
                <div class="col-lg-5 col-md-6 pl-md-0 pr-md-3">
                    <div class="card bg-white-green">
                        <div class="card-body">
                            <div class="d-inline-block bg-misty-green img-circle p-3">
                                <i class="fa fa-upload fa-2x"></i>
                            </div>
                            <h4 class="text-capitalize mt-4">Export Guests Email To Schedule Follow-Up Email Sequences Using Exist CRM</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 pl-md-3 pr-md-0">
                    <div class="card bg-white-purple">
                        <div class="card-body">
                            <div class="d-inline-block bg-misty-purple img-circle p-3">
                                <i class="fa fa-th-large fa-2x mx-1"></i>
                            </div>
                            <h4 class="text-capitalize mt-4">See All Your Meetings And Guests in Dashboard</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1"></div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card bg-white-yellow">
                        <div class="card-body">
                            <div class="d-inline-block bg-misty-yellow img-circle p-3">
                                <i class="fa fa-bell fa-2x"></i>
                            </div>
                            <h4 class="text-capitalize mt-4">Notifies You And Your Guests Prior To The Schedule</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>

    <div class="container text-center text-md-left pt-5">
        <div class="py-4"></div>
        <div class="row py-5">
            <div class="col-md-7 position-relative">
                <div class="pr-md-5 absolute-center">
                    <h3 class="font-weight-bold text-regal-blue text-capitalize">Book meeting in 15 seconds</h3>
                    <p class="mt-3 mt-md-0 mt-lg-4">Click the right mouse when you see a hyperlinked word or email address in your chat.
                        {{ $setting['site_name'] }} invite is added to your contextual menu. Click on {{ $setting['site_name'] }} Invite and you are just 15 seconds away from booking a meeting.</p>
                </div>
            </div>
            <div class="col-md-5">
                <img src="{{ asset('public/assets/images/book_meeting.jpg') }}" alt="Book meeting Image" class="w-100" style="border-radius: 1rem;">
            </div>
        </div>
        <div class="py-4"></div>
        <div class="row py-5">
            <div class="col-md-7">
                <img src="{{ asset('public/assets/images/all_meetings.PNG') }}" alt="All Meeting Image" class="w-100" style="border-radius: 1rem;">
            </div>
            <div class="col-md-5 pt-3 pt-md-0">
                <div class="pl-md-5 absolute-center">
                    <h3 class="font-weight-bold text-regal-blue text-capitalize">Keep a track of all your meetings in One place</h3>
                    <p class="mt-3 mt-md-0 mt-lg-4">View your today's or upcoming meetings in your dashboard. Be always on time by keeping a track of every scheduled meeting.</p>
                </div>
            </div>
        </div>
        <div class="py-4"></div>
        <div class="row py-5">
            <div class="col-md-5">
                <div class="pr-md-5 absolute-center">
                    <h3 class="font-weight-bold text-regal-blue text-capitalize">Build & Grow relationships with your prospects</h3>
                    <p class="mt-3 mt-md-0 mt-lg-4">Whenever you schedule your meeting via {{ $setting['site_name'] }}, guests are automatically added to your guest lists in the dashboard.
                        You can view them, contact them, make follow ups after meeting.</p>
                </div>
            </div>
            <div class="col-md-7">
                <img src="{{ asset('public/assets/images/all_guests.PNG') }}" alt="All Guests Image" class="w-100" style="border-radius: 1rem;">
            </div>
        </div>
        <div class="py-4"></div>
    </div>

    <?php
    $video = $setting['how_video'];
    if (stripos($video, 'youtube.com') !== false) {
        $video = str_replace('/watch?v=', '/embed/', $video);
        if (stripos($video, '?') !== false) {
            $video .= '&enablejsapi=1';
        } else {
            $video .= '?enablejsapi=1';
        }
    }
    ?>
    <!-- How it works Modal -->
    <div class="modal fade" id="how-it-works-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">How Pigeon works?</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <iframe id="how-it-works-video" src="{{ $video }}" frameborder="0" style="width: 100%; height: 50vh;"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#how-it-works-modal').on('hidden.bs.modal', function () {
            document.getElementById('how-it-works-video').contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
        });
    </script>
@endsection