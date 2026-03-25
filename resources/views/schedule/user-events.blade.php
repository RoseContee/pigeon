@extends('layouts')

@section('title', $user['name'])

@section('seo')
    <meta name="description" content="Welcome to my scheduling page. Please follow the instructions to add an event to my calendar."/>

    <meta property="og:title" content="{{ $user['name'] }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:description" content="Welcome to my scheduling page. Please follow the instructions to add an event to my calendar."/>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-12 mb-3">
                <img src="{{ $user['avatar'] }}" class="img-circle" alt="User Avatar" style="max-width: 70px;">
            </div>
            <div class="col-12 mb-4">
                <h5 class="text-bold text-black-50">{{ $user['name'] }}</h5>
            </div>
            <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2">
                <p class="text-black-50">Welcome to my scheduling page. Please follow the instructions to add an event to my calendar.</p>
            </div>
        </div>
        <div class="row">
            @foreach ($events as $event)
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="{{ route('user-event', ['name' => $user['slug'], 'event' => $event['slug']]) }}" class="card text-center text-dark">
                        <div class="card-header p-3">
                            <h5 class="ellipsis-title">{{ $event['name'] }}</h5>
                        </div>
                        <div class="card-body p-3">
                            <p><i class="fa fa-clock-o"></i> {{ $event['duration'] }} min</p>
                            <p class="ellipsis-title">{{ $event['description'] }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection