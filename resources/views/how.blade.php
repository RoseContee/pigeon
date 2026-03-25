@extends('layouts')

@section('title', 'How it works')

@section('seo')
    <meta name="description" content="Learn how to install and setup Pigeon Extension for the first time"/>

    <meta property="og:title" content="How it works | PIGEON"/>
    <meta property="og:url" content="{{ route('how') }}"/>
    <meta property="og:description" content="Learn how to install and setup Pigeon Extension for the first time"/>
@endsection

@section('content')
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
    <div class="container mt-5">
        <h1 class="font-weight-light text-regal-blue">How {{ $setting['site_name'] }} works? </h1>
        <iframe width="560" height="315" src="{{ $video }}" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
@endsection