@extends('new.public.layout')

@section('title', trans('public/index.title'))

@section('content')

    <section id="cover" class="big bg-img-tomatoes image wc text-center pt-5">
        <div class="container h-100">
            <div class="row h-100">

                <div class="col-sm-12 offset-sm-2 col-md-16 offset-md-0 my-auto">

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
        @include('new.components.arrow', ['dark' => false])
    </section>

    <section class="medium-min bg-main-primary pt-6 pb-6 pb-lg-0">
        <div class="container">
            <div class="row wc">
                <div class="col-lg-4 col-sm-16 text-center text-lg-left">
                    <h2 class="mt-3">{{ trans('public/pages/find-out-more.header_2') }}</h2>
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
        @include('new.components.arrow', ['dark' => false])
    </section>

    <section class="bg-accent-light-12 container-fluid py-5">

        <div class="offset-lg-1 map-site-info p-3">
            <div class="row">
                <div class="col">
                    <h4 class="m-0">1129</h4>
                    <small>Användare</small>
                </div>

                <div class="col">
                    <h4 class="m-0">41</h4>
                    <small>Noder</small>
                </div>

                <div class="col">
                    <h4 class="m-0">110</h4>
                    <small>Producenter</small>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-10 col-sm-7 col-md-6 col-lg-5 col-xl-4">
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

    @include('new.components.sections.medium-gradient', [
        'image'     => 'basket',
        'heading'   => 'public/index.create_and_shop',
        'paragraph' => 'public/index.create_and_shop_paragraph',
        'button_text'    => 'public/create-account.user_header',
        'inverted'  => false,
        'global'     => 'rh2',
        'button'    => 'secondary',
        'color'     => 'accent'
    ])

    @include('new.components.sections.medium-gradient', [
        'image'     => 'party',
        'heading'   => 'public/index.not_found_local',
        'paragraph' => 'public/index.not_found_local_paragraph',
        'button_text'    => 'public/index.create_place',
        'inverted'  => true,
        'global'     => 'wh2',
        'button'    => 'secondary',
        'color'     => 'accent'
    ])

    @include('new.components.sections.medium-gradient', [
        'image'     => 'carrots',
        'heading'   => 'public/index.food_producer',
        'paragraph' => 'public/index.food_producer_paragraph',
        'button_text'    => 'admin/user-nav.create_producer',
        'inverted'  => false,
        'global'     => 'wh2 wp',
        'button'    => 'primary',
        'color'     => 'primary'
    ])

    {{-- MEMBERSHIP --}}
    <section class="bg-accent-light-12 text-center py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-3">
                    <h4 class="pb-5">{{ trans('public/pages/membership.title') }}</h4>
                    <h2 class="text-uppercase">{{ trans('public/index.co_fund_heading') }}</h2>
                    <P>{{ trans('public/index.co_fund_subheading') }}</P>

                    <div class="row py-4">
                        <div class="col-md-8">
                            @include('new.components.statistics.supporting-members')
                        </div>

                        <div class="col-md-8">
                            @include('new.components.statistics.average-fee')
                        </div>
                    </div>
                    <p>{{ trans('public/index.co_fund_paragraph_short') }}</p>

                    <p class="rc text-uppercase mb-5">{{ trans('public/index.co_fund_read_more') }}</p>
                </div>
            </div>
        </div>
        @include('new.components.arrow', ['dark' => true])
    </section>

    {{-- ECONOMY --}}
    <section class="medium bg-accent-light-24 text-center">
        <div class="container">
            <h4 class="py-5">{{ trans('public/economy.economy') }}</h4>
            <metrics translations="{{ json_encode(trans('public/economy')) }}"></metrics>
            <p>{{ trans('public/index.transparency_short') }}</p>
            <span class="rc text-uppercase">{{ trans('public/economy.read_more_economy') }}</span>
        </div>
        @include('new.components.arrow', ['dark' => true])
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

    <section class="bg-accent-light-24">
        @include('new.components.register')
    </section>

@endsection
