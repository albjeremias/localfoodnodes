@extends('new.public.layout',
[
    'transparent_nav' => true,
    'public_nav'      => true,
])

@section('title', __('Find local food neary you'))

@section('content')

    <section id="cover" class="big bg-img-tomatoes image wc text-center pt-5">
        <div class="container h-100">
            <div class="row h-100">

                <div class="m-auto">

                    <h3>LOCAL FOOD NODES</h3>
                    <h1 class="text-uppercase my-3">@lang('Co-create the local food supply')</h1>
                    <h2>@lang('Find your local delivery location')</h2>

                    <div class="input-group input-group-lg mx-auto mt-5">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <input type="text" class="form-control" id="search_input" placeholder="@lang('Find your local delivery location')">
                    </div>

                    <p class="mt-3">
                        <small class="wc">@lang('Search for location')</small>
                    </p>

                </div>
            </div>
        </div>
        @include('new.components.arrow', ['dark' => false, 'classes' => ''])
    </section>

    {{-- HOW DOES IT WORK --}}
    <section class="bg-main-primary pt-5">
        <div class="container pt-5">
            <div class="row wc">
                <div class="col-lg-4 col-sm-16 text-center text-lg-left">
                    <h2 class="mt-3">@lang('Co-create the local food supply')</h2>
                    <p>@lang('We believe in people\'s ability to self-determination and co-determination around our basic needs. To jointly create us higher resilience as individuals and communities in all flows we depend on. Food, ecology, economy and our personal integrity.')</p>
                    <a class="btn btn-primary mt-lg-4" href="#">@lang('Read more')</a>
                </div>

                <div class="col-lg-4 col-sm-16 mt-5 mt-lg-0">
                    @include('new.components.cards.simple', [
                        'bg'   => 'basket',
                        'text' => __('Create account and order local food')
                    ])
                </div>

                <div class="col-lg-4 col-sm-16">
                    @include('new.components.cards.simple', [
                        'bg'   => 'party',
                        'text' => __('Start a node near your')
                    ])
                </div>

                <div class="col-lg-4 col-sm-16">
                    @include('new.components.cards.simple', [
                        'bg'   => 'carrots',
                        'text' => __('Sell your products')
                    ])
                </div>
            </div>
        </div>
        @include('new.components.arrow', ['dark' => false, 'classes' => 'pb-3 pt-2 pt-lg-5 pb-lg-2'])
    </section>

    <section class="bg-accent-light-12 node-map">
        <div id="node-map-component-root" data-ip="{{ Request::ip() }}" data-user-location="{{ json_encode($user->location) }}" data-lang="{{ app()->getLocale() }}"></div>
        <div class="map-site-info p-3 d-none d-xl-block">
            <div class="row">
                <div class="col">
                    <h4 class="m-0">{{ $metrics['userCount'] }}</h4>
                    <small>@lang('Users')</small>
                </div>

                <div class="col px-5">
                    <h4 class="m-0">{{ $metrics['nodeCount'] }}</h4>
                    <small>@lang('Nodes')</small>
                </div>

                <div class="col">
                    <h4 class="m-0">{{ $metrics['producerCount'] }}</h4>
                    <small>@lang('Producers')</small>
                </div>
            </div>
        </div>
    </section>

    {{-- MAP --}}
    <!-- <section class="bg-accent-light-12 py-5">
        <div class="container">
            <div class="map-site-info p-3 d-none d-xl-block">
                <div class="row">
                    <div class="col">
                        <h4 class="m-0">1129</h4>
                        <small>{{ trans('public/index.map_users') }}</small>
                    </div>

                    <div class="col px-5">
                        <h4 class="m-0">41</h4>
                        <small>{{ trans('public/index.map_nodes') }}</small>
                    </div>

                    <div class="col">
                        <h4 class="m-0">110</h4>
                        <small>{{ trans('public/index.map_producers') }}</small>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                @include('new.components.cards.node',
                [
                    'name'      => 'Dalby Saluhall',
                    'address'   => 'Dalbysaluhallväg 1, 21144 Dalby',
                    'bio'       => 'Välkommen att handla i Byggdens Saluhall Dalby',
                    'time'      => 'Tis, 12:00',
                    'producers' => '12',
                    'link'      => '/node/bygdens-saluhall-billinge'
                ])
            </div>
        </div>
    </section> -->

    {{-- GRADIENTS --}}
    @include('new.components.sections.medium-gradient', [
        'image'          => 'basket',
        'heading'        => __('Create account and start shopping locally'),
        'paragraph'      => __('You can easily create an account for free. Look around at the site, find extra places when you go and enjoy local food in your digital shopping cart. Before you can order your food you need to be a support member, then the manufacturer will ship your goods to the extradition site.'),
        'button_text'    => __('Create account'),
        'inverted'       => false,
        'global'         => 'rh2',
        'button'         => 'secondary',
        'color'          => 'accent',
        'sm_bg'          => 'bg-main-accent',
        'button_swap'    => false
    ])

    @include('new.components.sections.medium-gradient', [
        'image'          => 'party',
        'heading'        => __('Didn\'t find a node near you'),
        'paragraph'      => __('An extradition site can be started and operated by a society, a cooperative, another organization or an individual. All that is needed is an address.'),
        'button_text'    => __('Create node'),
        'inverted'       => true,
        'global'         => 'wh2',
        'button'         => 'secondary',
        'color'          => 'accent',
        'sm_bg'          => 'bg-main-primary',
        'button_swap'    => 'primary'
    ])

    @include('new.components.sections.medium-gradient', [
        'image'          => 'carrots',
        'heading'        => __('Are you a producer'),
        'paragraph'      => __('Add your products and link them to your local nodes. Delivery and payment will be made directly to the customer on delivery. All profil goes directly to you so you can develop and continue with what you do. Nobody else but you will make money from producing good food!'),
        'button_text'    => __('Create producer'),
        'inverted'       => false,
        'global'         => 'wh2 wp',
        'button'         => 'primary',
        'color'          => 'primary',
        'sm_bg'          => 'bg-main-accent',
        'button_swap'    => 'secondary'
    ])

    {{-- MEMBERSHIP --}}
    <section class="bg-accent-light-12 text-center pt-5 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-3">
                    <h4 class="pb-4">@lang('Membership')</h4>
                    <h2 class="text-uppercase">@lang('Co-own the future of food')</h2>
                    <P class="mb-0">@lang('You choose your membership fee')</P>

                    <div class="row py-5">
                        <div class="col-md-8">
                            @include('new.components.statistics.supporting-members')
                        </div>

                        <div class="col-md-8 mt-4 mt-md-0">
                            @include('new.components.statistics.average-fee')
                        </div>
                    </div>
                    <p class="w-75 text-center mx-auto">@lang('By becoming a member, you co-finance efforts to make the food more local again. Together we create economic conditions for supporting new forms of local')</p>

                    <p class="rc text-uppercase mt-4">@lang('Read more')</p>
                </div>
            </div>
        </div>
        @include('new.components.arrow', ['dark' => true, 'classes' => 'pb-3 pt-2'])
    </section>

    {{-- ECONOMY --}}
    <section class="medium bg-accent-light-24 text-center">
        <div class="container">
            <h4 class="py-5">@lang('Economy')</h4>
            <metrics translations=""></metrics>
            <p>@lang('Local Food Nodes has 100% financial transparency. Below you can see all the income and expenses of the year. Go to our finance page for more ...')</p>
            <span class="rc text-uppercase">@lang('Read more about our economy')</span>
        </div>
        @include('new.components.arrow', ['dark' => true, 'classes' => 'pb-3 pt-2'])
    </section>

    <section class="medium text-center bg-img-party-red image wc">
        {{--<section class="medium text-center bg-img-party image">--}}
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-16 mx-auto">
                    <h1>#LETSGOLOCAL</h1>
                    <h3 class="pb-4">@lang('A desire to make the food local again')</h3>

                    <a class="btn-lg btn-primary mt-5 text-uppercase"
                       href="#">@lang('Read more about our vision')</a>
                </div>
            </div>
        </div>
    </section>

    {{-- REGISTER --}}
    <section class="bg-accent-light-24">
        @include('new.components.register')
    </section>

    <script>
        scrollYPoint = 20; // Att what pixel the navbar shall transform.

        // Makes sure the navbar is in the right state if
        // the visitor refreshes the page while scrolled down.
        if (window.scrollY >= scrollYPoint) {
            $('#nav-container').addClass('bg-black-54');
        }

        // Handles the navbar state when scrolling.
        window.onscroll = function () {
            if (window.scrollY <= scrollYPoint) {
                $('#nav-container').removeClass('bg-black-54');
            } else {
                $('#nav-container').addClass('bg-black-54');
            }
        };
    </script>

    <script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>
    <script src="/js/node-map.js"></script>
@endsection
