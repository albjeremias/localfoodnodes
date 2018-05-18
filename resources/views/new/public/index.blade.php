@extends('public.layout')

@section('title', trans('public/index.title'))

@section('content')

    <section class="medium bg-main-primary pt-6">
        <div class="container">
            <div class="row wc">
                <div class="col-md-4">
                    <h5 class="mt-3">{{ trans('public/pages/find-out-more.header_2') }}</h5>
                    <p>{{ trans('public/index.how_it_works_intro') }}</p>
                    <a class="btn btn-primary mt-4" href="#">{{ trans('public/index.read_more') }}</a>
                </div>

                <div class="col-md-4">
                    @include('new.components.cards.simple', [
                        'bg'   => 'basket',
                        'text' => trans('public/index.create_and_shop')
                    ])
                </div>

                <div class="col-md-4">
                    @include('new.components.cards.simple', [
                        'bg'   => 'party',
                        'text' => trans('public/index.not_found_local')
                    ])
                </div>

                <div class="col-md-4">
                    @include('new.components.cards.simple', [
                        'bg'   => 'carrots',
                        'text' => trans('public/index.food_producer')
                    ])
                </div>
            </div>
        </div>
    </section>

    @include('new.components.sections.medium-gradient', [
        'image'     => 'basket',
        'heading'   => 'public/index.create_and_shop',
        'paragraph' => 'public/index.create_and_shop_paragraph',
        'button_text'    => 'public/create-account.user_header',
        'inverted'  => false,
        'global'     => 'rh',
        'button'    => 'secondary',
        'color'     => 'accent'
    ])

    @include('new.components.sections.medium-gradient', [
        'image'     => 'party',
        'heading'   => 'public/index.not_found_local',
        'paragraph' => 'public/index.not_found_local_paragraph',
        'button_text'    => 'public/index.create_place',
        'inverted'  => true,
        'global'     => 'wh',
        'button'    => 'secondary',
        'color'     => 'accent'
    ])

    @include('new.components.sections.medium-gradient', [
        'image'     => 'carrots',
        'heading'   => 'public/index.food_producer',
        'paragraph' => 'public/index.food_producer_paragraph',
        'button_text'    => 'admin/user-nav.create_producer',
        'inverted'  => false,
        'global'     => 'wh wp',
        'button'    => 'primary',
        'color'     => 'primary'
])

@endsection
