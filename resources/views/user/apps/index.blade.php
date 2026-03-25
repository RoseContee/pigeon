@extends('user.partials.layout')

@section('title', 'Apps')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">Apps</h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="content text-center">
        <div class="container-fluid">
            <div class="row">
                @foreach ($apps as $app)
                    <div class="col-xl-2 col-lg-3 col-sm-4 col-6">
                        <div class="card">
                            <div class="card-body">
                                <span class="meeting-badge p-1
                                @if ($app['id'] % 7 == 1) bg-danger @elseif ($app['id'] % 7 == 2) bg-info @elseif ($app['id'] % 7 == 3) bg-success
                                @elseif ($app['id'] % 7 == 4) bg-warning @elseif ($app['id'] % 7 == 5) bg-primary @elseif ($app['id'] % 7 == 6) bg-secondary
                                @else bg-gray @endif">{{ $app['name'] }}</span>
                            </div>
                            <a href="{{ route('edit-app', $app['name']) }}" class="card-footer py-1">
                                @if (empty($app_data['app_link_'.$app['id']])) Not @endif Connected
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('script')
@endsection