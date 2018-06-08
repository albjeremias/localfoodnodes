@extends('new.public.layout',
[
    'transparent_nav' => true,
    'public_nav'      => true,
])

@section('title', trans('public/index.title'))

@section('content')

    <section id="cover" class="big bg-img-tomatoes image wc text-center pt-5">
        <div class="container h-100">
            <div class="row h-100">

                <div class="m-auto">

                    <h3>LOCAL FOOD NODES</h3>
                    <h1 class="text-uppercase my-3">{{ trans('public/index.co_create') }}</h1>
                    <h2>{{ trans('public/index.found_your_local') }}</h2>

                    <div class="input-group input-group-lg mx-auto mt-5">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <input type="text" class="form-control" id="search_input"
                               placeholder="{{ trans('public/index.found_your_local') }}">
                    </div>

                    <p class="mt-3">
                        <small class="wc">{{ trans('public/index.index_seach') }}</small>
                    </p>

                </div>
            </div>
        </div>
        @include('new.components.arrow', ['dark' => false, 'classes' => ''])
    </section>

    <section class="bg-main-primary pt-5">
        <div class="container pt-5">
            <div class="row wc">
                <div class="col-lg-4 col-sm-16 text-center text-lg-left">
                    <h2 class="mt-3">{{ trans('public/index.find_out_more') }}</h2>
                    <p>{{ trans('public/index.how_it_works_intro') }}</p>
                    <a class="btn btn-primary mt-lg-4" href="#">{{ trans('public/index.read_more') }}</a>
                </div>

                <div class="col-lg-4 col-sm-16 mt-5 mt-lg-0">
                    @include('new.components.cards.simple', [
                        'bg'   => 'basket',
                        'text' => trans('public/index.create_and_shop')
                    ])
                </div>

                <div class="col-lg-4 col-sm-16">
                    @include('new.components.cards.simple', [
                        'bg'   => 'party',
                        'text' => trans('public/index.not_found_local')
                    ])
                </div>

                <div class="col-lg-4 col-sm-16">
                    @include('new.components.cards.simple', [
                        'bg'   => 'carrots',
                        'text' => trans('public/index.food_producer')
                    ])
                </div>
            </div>
        </div>
        @include('new.components.arrow', ['dark' => false, 'classes' => 'pb-3 pt-2 pt-lg-5 pb-lg-2'])
    </section>

    {{-- MAP --}}
    <section class="bg-accent-light-12 py-5">
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
    </section>

    {{-- GRADIENTS --}}
    @include('new.components.sections.medium-gradient', [
        'image'          => 'basket',
        'heading'        => 'public/index.create_and_shop',
        'paragraph'      => 'public/index.create_and_shop_paragraph',
        'button_text'    => 'public/index.create-account',
        'inverted'       => false,
        'global'         => 'rh2',
        'button'         => 'secondary',
        'color'          => 'accent',
        'sm_bg'          => 'bg-main-accent',
        'button_swap'    => false
    ])

    @include('new.components.sections.medium-gradient', [
        'image'          => 'party',
        'heading'        => 'public/index.not_found_local',
        'paragraph'      => 'public/index.not_found_local_paragraph',
        'button_text'    => 'public/index.create_place',
        'inverted'       => true,
        'global'         => 'wh2',
        'button'         => 'secondary',
        'color'          => 'accent',
        'sm_bg'          => 'bg-main-primary',
        'button_swap'    => 'primary'
    ])

    @include('new.components.sections.medium-gradient', [
        'image'          => 'carrots',
        'heading'        => 'public/index.food_producer',
        'paragraph'      => 'public/index.food_producer_paragraph',
        'button_text'    => 'public/index.create_producer',
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
                    <h4 class="pb-4">{{ trans('public/index.membership') }}</h4>
                    <h2 class="text-uppercase">{{ trans('public/index.co_fund_heading') }}</h2>
                    <P class="mb-0">{{ trans('public/index.co_fund_subheading') }}</P>

                    <div class="row py-5">
                        <div class="col-md-8">
                            @include('new.components.statistics.supporting-members')
                        </div>

                        <div class="col-md-8 mt-4 mt-md-0">
                            @include('new.components.statistics.average-fee')
                        </div>
                    </div>
                    <p class="w-75 text-center mx-auto">{{ trans('public/index.co_fund_paragraph_short') }}</p>

                    <p class="rc text-uppercase mt-4">{{ trans('public/index.co_fund_read_more') }}</p>
                </div>
            </div>
        </div>
        @include('new.components.arrow', ['dark' => true, 'classes' => 'pb-3 pt-2'])
    </section>

    {{-- ECONOMY --}}
    <section class="medium bg-accent-light-24 text-center">
        <div class="container">
            <h4 class="py-5">{{ trans('public/index.economy') }}</h4>
            <metrics translations="{{ json_encode(trans('public/economy')) }}"></metrics>
            <p>{{ trans('public/index.transparency_short') }}</p>
            <span class="rc text-uppercase">{{ trans('public/index.read_more_economy') }}</span>
        </div>
        @include('new.components.arrow', ['dark' => true, 'classes' => 'pb-3 pt-2'])
    </section>

    <section class="medium text-center bg-img-party-red image wc">
        {{--<section class="medium text-center bg-img-party image">--}}
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-16 mx-auto">
                    <h1>#LETSGOLOCAL</h1>
                    <h3 class="pb-4">{{ trans('public/index.longing_for_local') }}</h3>

                    <a class="btn-lg btn-primary mt-5 text-uppercase"
                       href="#">{{ trans('public/index.more_vision') }}</a>
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

@endsection
