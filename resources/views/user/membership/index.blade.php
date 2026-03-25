@extends('user.partials.layout')

@section('title', 'Membership')

@section('content')
    <div class="content-header mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-dark">Membership</h4>
                </div>
                <!-- /.col -->
                <div class="col-12 mt-3">
                    You have a free membership account with limitation benefits.
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <div id="membership-plan-area" class="content text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="offset-md-2 col-md-8">
                    <h3>Try a {{ $setting['site_name'] }} Membership</h3>
                    <p>Change plans anytime! Save up on annual plans.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs d-sm-inline-flex elevation-1" role="tablist">
                        @foreach ($packages as $package)
                            <li class="nav-item">
                                <a class="nav-link @if ($current['membership_package_id'] == $package['id']) active show @endif"
                                   data-toggle="pill" href="#membership-plan-{{ $package['id'] }}" role="tab">{{ $package['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body tab-content">
                            @foreach ($packages as $package)
                                <div id="membership-plan-1" class="row tab-pane active show" role="tabpanel">
                                    @foreach ($memberships as $membership)
                                        @if ($membership['membership_package_id'] != $package['id']) @continue @endif
                                        <div class="col-xl-3 col-lg-4 col-sm-6">
                                            <div class="package_content @if ($membership['id'] == Auth::user()->membership_id) active @endif">
                                                <div class="package_head_price">
                                                    <div class="package_head_content">
                                                        <div class="head_bg"></div>
                                                        <div class="head">
                                                            <span>{{ $membership['name'] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="package_price_tag">
                                                        <span class="price">
                                                            <span class="currency">
                                                                <b class="small">$</b> {{ $membership['price'] }}
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="package_feature_list">
                                                    <ul class="text-left">
                                                        <?php
                                                            $descriptions = explode("\n", $membership['description']);
                                                        ?>
                                                        @foreach ($descriptions as $description)
                                                            <li class="px-2 py-0">{{ $description }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="package_price_btn">
                                                    <a @if ($membership['id'] != Auth::user()->membership_id) href="javascript:void(0);" @endif>
                                                        @if ($membership['id'] == Auth::user()->membership_id)
                                                            Current
                                                        @else
                                                            Upgrade
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('script')
@endsection