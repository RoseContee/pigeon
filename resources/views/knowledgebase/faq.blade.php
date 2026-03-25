@extends('layouts')

@section('title', 'FAQ')

@section('seo')
    <meta name="description" content=""/>

    <meta property="og:title" content="FAQ | PIGEON"/>
    <meta property="og:url" content="{{ route('faq') }}"/>
    <meta property="og:description" content=""/>
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-black-50 mb-4">
                <a href="{{ route('knowledgebase') }}" class="text-dark">Knowledge Base</a>
                <i class="fa fa-arrow-right mx-2"></i> FAQ
            </div>
            <div class="col-12">
                <h3 class="text-center mb-5">Frequently Asked Questions</h3>
            </div>
            <div class="col-12">
                <h5 class="mb-3 text-bold">Why as a host I am not getting notifications about the booked meetings?</h5>
                <p>
                    - Pigeon currently works with Google Calendar only. By default Google Calendar sends notifications
                    to guests only but reminders to hosts & guests both.<br>
                </p>
            </div>
            <div class="col-12 mt-3">
                <h5 class="mb-3 text-bold">How many guests can I add to my meetings?</h5>
                <p>
                    - When you book a meeting via Pigeon Chrome Extension, it allows you to add up to 10 guests in a single meeting.
                    But you must be informed that meeting platforms may have restrictions on participation counts based account type i.e. free or paid.<br>
                </p>
                <p>
                    Google Meet & Zoom, both allow up to 100 participants in a single meeting for free account users.<br>
                </p>
            </div>
            <div class="col-12 mt-3">
                <h5 class="mb-3 text-bold">I don't see a pricing page on Pigeon, is it free?</h5>
                <p>
                    We released Pigeon a few weeks ago and are trying to work with our early users to optimize services.<br>
                </p>
                <p>
                    We are working on our subscription plans. Till the time, we don't announce fees precisely,
                    Pigeon is free for use but with limited access.<br>
                </p>
            </div>
            <div class="col-12 mt-3">
                <h5 class="mb-3 text-bold">Why am I unable to create new events?</h5>
                <p>
                    If you are using Pigeon as a free member, you are allowed to create one active event at a time.<br>
                </p>
                <p>
                    If you need to create another event, you will have to deactivate the last active event.<br>
                </p>
            </div>
        </div>
    </div>
@endsection