@extends('public.layout')

@section('title', trans('public/index.title'))

@section('content')
    <div class="container-fluid frontpage-section frontpage-header">
        <div class="container">
            <div class="col-12 header-block">
                <h1 class="bold">
                    {{ trans('public/index.header') }}
                    <div class="sub-header">{!! trans('public/index.subheader') !!}</div>
                </h1>
            </div>
        </div>
    </div>

    <div class="container-fluid frontpage-section bg-white what-is-lfn">
        <div class="container d-flex justify-content-center text-center">
            <div class="col-12 pt-5 pb-5">
                <h2 class="thin">{{ trans('public/index.what_is_lfn') }}</h2>
                <p class="pt-5 pb-5 text-left">{{ trans('public/index.what_is_lfn_info') }}</p>
                <img src="/images/infographic.jpg">
                <div>
                    <a href="/find-out-more" class="btn btn-primary">{{ trans('public/index.find_out_more') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="map-wrapper">
        <?php $jsonTrans = json_encode(trans('public/index')); ?>
        <div class="node-map" id="node-map-component-root" data-ip="{{ Request::ip() }}" data-user-location="{{ json_encode($user->location) }}" data-trans="{{ $jsonTrans }}"></div>

        <div class="metrics">
            <div class="metric">
                <div class="value">{{ $metrics['userCount'] }}</div>
                <div class="label">{{ trans('public/index.locals') }}</div>
            </div>
            <div class="metric">
                <div class="value">{{ $metrics['nodeCount'] }}</div>
                <div class="label">{{ trans('public/index.local_nodes') }}</div>
            </div>
            <div class="metric">
                <div class="value">{{ $metrics['producerCount'] }}</div>
                <div class="label">{{ trans('public/index.local_producers') }}</div>
            </div>
        </div>
    </div>

    <div class="container frontpage-section create-pushes mt-5">
        <h2 class="thin mb-5">{{ trans('public/index.co_create') }}</h2>

        {!! trans('public/index.co_create_info') !!}

        <div class="card-deck mt-5">
            <div class="card mb-5">
                <img class="card-img-top" src="/images/shutterstock_436974091.jpg" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">{{ trans('public/index.create_user_info') }}</p>
                </div>
                <div class="card-footer">
                    <a class="btn btn-primary" href="/account/user/create/user">{{ trans('public/index.create_user') }}</a>
                </div>
            </div>

            <div class="card mb-5">
                <img class="card-img-top" src="/images/shutterstock_326785574.jpg" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">{{ trans('public/index.create_node_info') }}</p>
                </div>
                <div class="card-footer">
                    <a class="btn btn-primary" href="/account/user/create/node">{{ trans('public/index.create_node') }}</a>
                </div>
            </div>

            <div class="card mb-5">
                <img class="card-img-top" src="/images/shutterstock_271622087.jpg" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">{{ trans('public/index.create_producer_info') }}</p>
                </div>
                <div class="card-footer">
                    <a class="btn btn-primary" href="/account/user/create/producer">{{ trans('public/index.list') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid frontpage-section membership mt-5 pt-5 pb-5">
        <div class="col-12">
            <h2 class="bold mb-5">
                {{ trans('public/index.co_fund_heading') }}
                <div class="sub-header">{{ trans('public/index.co_fund_subheading') }}</div>
            </h2>

            <div class="d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <p>{{ trans('public/index.co_fund_paragraph') }}</p>
                </div>
            </div>

            <div class="membership-metrics row">
                <div class="metric col">
                    <div class="value">{{ $members }}<i class="fa fa-user value-unit"></i></div>
                    <div class="label">{{ trans('public/pages/membership.supporting') }}</div>
                </div>
                <div class="metric col">
                    <div class="value">{{ $averageMembership }}<span class="value-unit">SEK</span></div>
                    <div class="label">{{ trans('public/pages/membership.avg_fee') }}</div>
                </div>
            </div>

            <a href="/membership" class="btn btn-primary mt-5">{{ trans('public/index.co_fund_read_more') }}</a>
        </div>
    </div>

    <script>
        var economyTrans = <?php echo json_encode(trans('public/economy')); ?>;
    </script>

    <div id="frontpage-metrics" class="frontpage-section">
        <div class="container pt-5 pb-5">
            <h2 class="thin mb-5">{{ trans('public/economy.economy') }}</h2>
            <div class="row mb-5">
                {!! trans('public/economy.economy_info') !!}
            </div>
            <metrics></metrics>
            <div class="text-center">
                <a class="btn btn-primary mt-5" href="/economy">{{ trans('public/economy.read_more_economy') }}</a>
                <a class="d-block mt-2" href="/economy/transactions">{{ trans('public/economy.view_all_transactions') }}</a>
            </div>
        </div>
    </div>

    <div class="container frontpage-section find-out-more mt-5" id="find-out-more">
        <img class="logo" src="/images/nav-logo-dark.png">
        <h2 class="thin mt-5 mb-5">{{ trans('public/pages/find-out-more.subheader_1') }}</h2>

        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <p>{{ trans('public/pages/find-out-more.paragraph_1_1') }}</p>
                <p>{{ trans('public/pages/find-out-more.paragraph_1_2') }}</p>
                <p>{{ trans('public/pages/find-out-more.paragraph_1_3') }}</p>
            </div>
            <div class="col-12 col-md-6">
                <p>{{ trans('public/pages/find-out-more.paragraph_1_4') }}</p>
                <p>{{ trans('public/pages/find-out-more.paragraph_1_5') }}</p>
                <p><i>{{ trans('public/pages/find-out-more.paragraph_1_6') }}</i></p>
            </div>
        </div>
    </div>

    <div class="container frontpage-section">
        <h2 class="thin mt-5 mb-5">#{{ trans('public/pages/find-out-more.quip') }}</h2>
    </div>

    <link rel="stylesheet" href="/css/leaflet/leaflet.min.css" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.0.3/dist/leaflet.markercluster.js"></script>
    <script src="{{ mix('/js/node-map.js') }}"></script>
    <script src="{{ mix('/js/frontpage.js') }}"></script>
@endsection
