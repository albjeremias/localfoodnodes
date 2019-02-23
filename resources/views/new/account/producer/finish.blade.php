@extends('new.account.layout',
[
    'nav_active'   => 1
])

@section('title', __('Producer account created'))

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
                <div class="row py-4 terms_intro">
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
            <h2 class=" mb-3">{{ __('Tell the world!') }}</h2>

            <p>
                {{ __('Share link below and post it where ever it suits you, telling your friends and followers you now have') }} {{ $producer->name  }} {{ __('set up at Local Food Nodes.') }}
            </p>

            <div class="d-flex">
                <div class="p-3 w-75" style="border: #bf360c dashed 1px; border-radius: 10px">
                    {{-- <div class="d-flex">
                        @foreach($producer->images() as $image)
                            <div class="mx-auto mt-1 mb-3" style="width: 50px">
                                <img class="image w-100" src="{{ $image->url('small') }}">
                            </div>
                        @endforeach
                    </div> --}}
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

            <h4 class="mt-5 mb-3">{{  __('Where do you want to go now?') }}</h4>
            <a href="{{ route('account_producer', ['producerId' => $producer->id]) }}" class="btn btn-secondary mr-2">{{ __('Dashboard') }}</a>
            <a href="{{ route('account_producer_channels', ['producerId' => $producer->id]) }}" class="btn btn-secondary mr-2">{{ __('Visit') }} {{ $producer->name }}</a>
            <a href="{{ route('account_product_create', ['producerId' => $producer->id]) }}" class="btn btn-secondary">{{ __('Create a product') }}</a>
        </div>
    </div>
@endsection
