    @extends('new.account.layout',
[
    'bread_type'     => __('Products'),
    'bread_result'   => $product->name,
    'sub_nav'        => 'producer',
    'sub_nav_active' => 1,
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')
    <div class="nms bg-shell">

        {{-- PLACEHOLDER - Will be replaced when we store selected producer in session. @NOTE David --}}
        @foreach ($user->producerAdminLinks() as $producerAdminLink)
            @php
                $active_producer_id = $producerAdminLink->getProducer()->id;
            @endphp
        @endforeach

        @if (!$product->images()->isEmpty())
            <div class="image product-background" style="background-image: url('{{ $product->images()->first()->url('large') }}')"></div>
        @endif

        <div class="product-info container nm">
            <div class="row">
                <div class="col-16">
                    <h1 class="d-inline-block">{{ $product->name }}</h1>

                    <ul class="list-inline pt-2">
                        <li class="list-inline-item mr-4">
                            <a class="btn btn-secondary box-shadow" href="#">{{ __('View product') }}</a>
                        </li>

                        <li class="list-inline-item mr-4 btn btn-white box-shadow">
                            <i class="fa fa-share-alt mr-2" aria-hidden="true"></i>
                            Share product
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <section id="overview">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-16 col-xl-10">
                        <div class="overview-box">
                            <h4>{{ __('Overview') }}</h4>
                            <p>{{ __('Here you can make more detailed customizations to best suit this specific product.
                                You can always reach this view at any time from your product administration view.') }}</p>

                            <a class="text-uppercase rc" href="{{ route('account_producer_products', ['producerId' => $producer->id]) }}">
                                {{ __('Back to products') }}
                            </a>
                        </div>
                    </div>

                    <div class="col-16 col-xl-6 mt-5 mt-xl-0">
                        <div class="product-stats">
                            <h4 class="mb-0">{{ __('Product stats') }}</h4>

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

