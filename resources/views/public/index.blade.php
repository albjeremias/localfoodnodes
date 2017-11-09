@extends('public.layout')

@section('title', trans('public/index.title'))

@section('content')
    <div class="container-fluid frontpage-section frontpage-header">
        <div class="push">
            <h2 class="bold">{{ trans('public/index.header') }}</h2>
            <p>{!! trans('public/index.subheader') !!}</p>
        </div>
    </div>

    <div class="container-fluid frontpage-section bg-white">
        <div class="container pt-5 pb-5">
            <h2 class="thin">What is Local Food Nodes</h2>
            <p>Anledningen till att vi skapar Local Food Nodes är att vi vill skapa nya kopplingar direkt mellan matproducenter och matkonsumenter samtidigt som vi vill stärka de lokala kopplingar som redan finns. Vi vill möjliggöra direkta transaktioner, resilienta samhällen och återfå närheten till maten vi äter och hur den är producerad. En vilja att göra maten lokal igen.
            </p>
            <div class="text-center">
                <img src="/images/infographic.jpg">
            </div>
        </div>
    </div>

    <div class="map-wrapper">
        <?php $jsonTrans = json_encode(trans('public/index')); ?>
        <div class="node-map" id="node-map-component-root" data-ip="{{ Request::ip() }}" data-user-location="{{ json_encode($user->location) }}" data-trans="{{ $jsonTrans }}"></div>

        <div class="metrics">
            <div class="metric">
                <b>{{ $metrics['userCount'] }}</b>
                <div>{{ trans('public/index.locals') }}</div>
            </div>
            <div class="metric">
                <b>{{ $metrics['nodeCount'] }}</b>
                <div>{{ trans('public/index.local_nodes') }}</div>
            </div>
            <div class="metric">
                <b>{{ $metrics['producerCount'] }}</b>
                <div>{{ trans('public/index.local_producers') }}</div>
            </div>
        </div>
    </div>

    <!-- <div class="container-fluid frontpage-section local-food-impact">
        <div class="container">
            <div class="row">
                <div class="col-12">

                </div>
            </div>
        </div>
    </div> -->

    @if (Auth::check())
        <div class="container-fluid frontpage-section create-pushes">
            <h2 class="thin">{{ trans('public/index.co_create') }}</h2>
            <div class="row no-gutters">
                <div class="col-12 col-lg nodes">
                    <h2 class="bold">{{ trans('public/index.no_node') }}</h2>
                    <a class="btn-outline" href="/account/node/create">{{ trans('public/index.create_node') }}</a>
                </div>
                <div class="col-12 col-lg producers">
                    <h2 class="bold">{{ trans('public/index.food_producer') }}</h2>
                    <a class="btn-outline" href="/account/producer/create">{{ trans('public/index.list') }}</a>
                </div>
            </div>
        </div>
    @else
        <div class="container frontpage-section create-pushes mt-5">
            <h2 class="thin mb-5">{{ trans('public/index.co_create') }}</h2>
            <div class="col-12">
                <div class="card-deck">
                    <div class="card">
                        <img class="card-img-top" src="/images/shutterstock_436974091_crate.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title">{{ trans('public/index.sign_up') }}</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-success" href="/account/user/create/user">{{ trans('public/index.sign_up_button') }}</a>
                        </div>
                    </div>

                    <div class="card">
                        <img class="card-img-top" src="/images/shutterstock_326785574_gettogether.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title">{{ trans('public/index.no_node') }}</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-success" href="/account/user/create/node">{{ trans('public/index.create_node') }}</a>
                        </div>
                    </div>

                    <div class="card">
                        <img class="card-img-top" src="/images/shutterstock_271622087_producer_carrots.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title">{{ trans('public/index.food_producer') }}</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-success" href="/account/user/create/producer">{{ trans('public/index.list') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container-fluid frontpage-section membership mt-5">
        <div class="col-12">
            <h2 class="bold">{{ trans('public/index.co_fund_heading') }}</h2>
            <h3 class="mb-5">{{ trans('public/index.co_fund_subheading') }}</h3>
            <div class="membership-content container">
                {{ trans('public/index.co_fund_paragraph') }}
            </div>

            <div class="metrics row">
                <div class="metric col">
                    <div class="value">{{ $members }}<i class="fa fa-user value-unit"></i></div>
                    <div class="label">{{ trans('public/pages/membership.supporting') }}</div>
                </div>
                <div class="metric col">
                    <div class="value">{{ $averageMembership }}<span class="value-unit">SEK</span></div>
                    <div class="label">{{ trans('public/pages/membership.avg_fee') }}</div>
                </div>
            </div>

            <a href="/membership" class="btn-outline">{{ trans('public/index.co_fund_read_more') }}</a>
        </div>
    </div>

    <div class="container frontpage-section find-out-more mt-5" id="find-out-more">
        <img class="logo" src="/images/nav-logo-dark.png">
        <h2 class="thin">{{ trans('public/pages/find-out-more.subheader_1') }}</h2>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 body-text">
                <p>{{ trans('public/pages/find-out-more.paragraph_1_1') }}</p>
                <p>{{ trans('public/pages/find-out-more.paragraph_1_2') }}</p>
                <p>{{ trans('public/pages/find-out-more.paragraph_1_3') }}</p>
                <p>{{ trans('public/pages/find-out-more.paragraph_1_4') }}</p>
                <p>{{ trans('public/pages/find-out-more.paragraph_1_5') }}</p>
                <p><i>{{ trans('public/pages/find-out-more.paragraph_1_6') }}</i></p>
            </div>
        </div>

        <h2 class="thin mt-5 mb-5">{{ trans('public/pages/find-out-more.header_2') }}</h2>
    </div>

    <div class="container frontpage-section find-out-more">
        <div class="row">
            <div class="card-deck">
                <div class="card">
                    <img class="card-img-top" src="/images/shutterstock_436974091_crate.jpg">
                    <div class="card-body">
                        <h3 class="card-title">{{ trans('public/pages/find-out-more.header_3') }}</h3>
                        <p>{{ trans('public/pages/find-out-more.paragraph_3_1') }}</p>
                        <p>{{ trans('public/pages/find-out-more.paragraph_3_2') }}</p>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="/images/shutterstock_326785574_gettogether.jpg">
                    <div class="card-body">
                        <h3 class="card-title">{{ trans('public/pages/find-out-more.header_4') }}</h3>
                        <p>{{ trans('public/pages/find-out-more.paragraph_4_1') }}</p>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="/images/shutterstock_271622087_producer_carrots.jpg">
                    <div class="card-body">
                        <h3 class="card-title">{{ trans('public/pages/find-out-more.header_5') }}</h3>
                        <p>{{ trans('public/pages/find-out-more.paragraph_5_1') }}</p>
                        <p>{{ trans('public/pages/find-out-more.paragraph_5_2') }}</p>
                    </div>
                </div>
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
@endsection
