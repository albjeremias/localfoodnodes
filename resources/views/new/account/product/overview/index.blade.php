@extends('new.account.layout',
[
    'sub_nav'        => 'producer',
    'sub_nav_active' => 1,
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')
    <div class="bg-shell">
        <div class="product-info container nm">
            <div class="row">
                <div class="col-16">
                    <div class="d-flex align-items-center mt-5">
                        @if (!$product->images()->isEmpty())
                            <div class="product-image-round mr-3">
                                <img class="rounded-circle" src="{{ $product->images()->first()->url('small') }}" />
                            </div>
                        @endif
                        <h2>{{ $product->name }}</h2>
                    </div>
                </div>
            </div>

            <div class="row mt-2 mb-3">
                <div class="col-16">
                    <a class="btn btn-white box-shadow mr-3" href="#">{{ __('View product') }}</a>
                    <button class="list-inline-item mr-4 btn btn-white box-shadow">
                        <i class="fa fa-share-alt mr-2" aria-hidden="true"></i>
                        Share product
                    </button>
                </div>
            </div>
        </div>

        <section id="overview">
            <div class="container">
                <div class="row my-2">
                    <div class="col-16 col-xl-10">
                        <div class="overview-box h-100">
                            <h4>{{ __('Overview') }}</h4>
                            <p>{{ __('Here you can make more detailed customizations to best suit this specific product.
                                You can always reach this view at any time from your product administration view.') }}</p>

                            <a class="text-uppercase rc" href="{{ route('account_producer_products', ['producerId' => $producer->id]) }}">
                                {{ __('Back to products') }}
                            </a>
                        </div>
                    </div>

                    <div class="col-16 col-xl-6 mt-3 mt-xl-0">
                        <div class="product-stats h-100">
                            <h4>{{ __('Product stats') }}</h4>

                            <div class="row mt-3">
                                <div class="col-16 col-sm-4 col-lg-3 col-xl-4">
                                    <h4 class="mb-0">1129</h4>
                                    <small>{{ __('Sold') }}</small>
                                </div>

                                <div class="col-16 col-sm-4 col-lg-3 col-xl-4">
                                    <h4 class="mb-0">41</h4>
                                    <small>{{ __('Pending') }}</small>
                                </div>

                                <div class="col-16 col-sm-8 col-lg-3 col-xl-8">
                                    <h4 class="mb-0">13.5 km</h4>
                                    <small>{{ __('Revenue') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="container">
            @include('new.account.product.overview.basic-info')

            @include('new.account.product.overview.stocks-and-variants')

            @include('new.account.product.overview.delivery-dates')

            @include('new.account.product.overview.meat-box')
        </div>
    </div>

        </div>
    </div>
@endsection

