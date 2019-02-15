@extends('new.account.layout',
[
    'bread_type'   => trans('public/nav.admin'),
    'bread_result' => trans('public/nav.create_producer'),
    'nav_active'   => 1
])

@section('title', trans('public/register.title_producer'))

@section('content')
    <div class="nms">
        @include('new.components.progress',
            [
                'active' => 3,
                'steps'  =>
                    [
                        __('Terms'),
                        __('Create producer'),
                        __('Sales channels'),
                        __('Finish')
                    ]
            ])


        <div class="bg-accent-light-24">
            <div class="container py-5">
                <div class="row py-4 terms_intro text-center">
                    <div class="col-xl-16">
                        <h2>{{ __('Nice work!') }}</h2>
                        {{ __('You now have a producer account for') }} {{  $producer->name }}
                        {{ __('at Local Food Nodes. An accont that you freely can use to sell and administer your
                            products, straight to local end-consumers, without any middleman, and without any
                            revenue-loss using the platform.') }}
                    </div>
                </div>
            </div>
        </div>


        <div class="container py-5">
            <div class="text-center">
                <h2 class=" mb-3">{{ __('Tell the world!') }}</h2>

                <p>
                    {{ __('Share link below and post it where ever it suits you, telling your friends and followers you now have') }} {{ $producer->name  }} {{ __('set up at Local Food Nodes.') }}
                </p>

                <div class="d-flex">
                    <div class="p-3 w-75 mx-auto" style="border: #bf360c dashed 1px; border-radius: 10px">
                        <div class="d-flex">
                            @foreach($producer->images() as $image)
                                <div class="mx-auto mt-1 mb-3" style="width: 50px">
                                    <img class="image w-100" src="{{ $image->url('small') }}">
                                </div>
                            @endforeach
                        </div>
                        <p>
                            {{ __('Whoopa') }},
                            {{ $producer->name }}
                            {{ __('is now registered at Local Food Nodes, the open source platform for prime local food, without any middlemen.
                                    Just great local food, from farmer to locals.
                                    Welcome to visit') }} {{ $producer->name }} {{ __('at Local Food Nodes and find out about us, our products and where to we deliver.
                                    #letsgolocal') }}
                        </p>
                        <button class="btn btn-sm btn-outline-secondary"><i class="fa fa-share-alt mr-2" aria-hidden="true"></i>{{ __('Share') }} {{ $producer->name }}</button>

                        {{--<a class="list-inline-item btn btn-white bb bottom-link-right">--}}
                            {{----}}
                            {{--Share product list--}}
                        {{--</a>--}}
                    </div>
                </div>

                <h4 class="mt-5 mb-3">{{  __('Choose where you want to go now') }}</h4>
                <a href="/account/producer/{{ $producer->id }}/channels" class="btn btn-secondary">{{ __('Visit') }} {{ $producer->name }}</a>
                <a href="/account/producer/{{ $producer->id }}" class="btn btn-secondary mx-3">{{ __('Dashboard') }}</a>
                <a href="/account/producer/{{ $producer->id }}/product/create" class="btn btn-secondary">{{ __('Create a product') }}</a>
                <div class="text-center">
                    <a href="/account/producer/{{ $producer->id }}/channels" class="btn btn-primary mt-5">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
