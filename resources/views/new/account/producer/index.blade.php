@extends('new.account.layout',
[
    'nav_title' => __('Dashboard'),
    'sub_nav' => 'producer',
    'nav_active' => 1,
    'sub_nav_active' => 0,
])

@section('title', 'Dashboard')

@section('content')
    <div class="bg-shell">
        <div class="container nm">
            <div class="row pt-2">
                <div class="col-md-10 col-lg-11">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="white-box little-min">
                                <a href="#" class="rc"><h4>{{ $producer->name }}</h4></a>
                                <ul class="list-unstyled list-p">
                                    <li>{{ Auth::user()->name }}</li>
                                    <li class="black-54">{{ Auth::user()->email }}</li>
                                    <li class="black-54">{{ $producer->address }}</li>
                                    <li class="black-54">{{ $producer->zip }} {{ $producer->city }}</li>
                                </ul>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <h3 class="m-0">1129</h3>
                                        <small>{{ __('Attended pickups') }}</small>
                                    </div>

                                    <div class="col-md-4">
                                        <h3 class="m-0">41</h3>
                                        <small>{{ __('Products sold') }}</small>
                                    </div>

                                    <div class="col pl-md-5">
                                        <h3 class="m-0">13.5 km</h3>
                                        <small>{{ __('Turnover') }}</small>
                                    </div>
                                </div>

                                <a class="bottom-link text-uppercase rc" href="{{ route('account_producer_edit', ['producerId' => $producer->id]) }}">{{ __('Edit profile') }}</a>
                                <span class="bottom-link-right" href="#">
                                    <small class="font-italic" data-toggle="tooltip" data-placement="bottom" title="Producer creation date">
                                        {{ \Carbon\Carbon::parse($producer->created_at)->toFormattedDateString() }}
                                    </small>
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="white-box little-min">
                                <a href="{{ route('membership') }}" class="rc"><h4>{{ __('Still not a member?') }}</h4></a>
                                <small>{{ _('Local Food Nodes is built on a gift based economy. By donating a supporting membership fee, free of choice, you are part of financing the development of open digital tools, that supports enabling local and independent peoples driven food markets.') }}</small>
                                <a class="bottom-link text-uppercase rc" href="{{ route('membership') }}">{{ __('Membership') }}</a>
                            </div>
                        </div>

                        <div class="col-16">
                            <div class="white-box medium-min">
                                @if($producer->orderDates()->count() <= 0)
                                    <a href="/account/producer/{{ $producer->id }}/deliveries" class="rc"><h4>{{ __('Deliveries') }}</h4></a>

                                    <div class="row h-100">
                                        <div class="col-16 my-auto text-center">
                                            <i class="fa fa-shopping-basket icon-big" aria-hidden="true"></i>
                                            <p class="mt-4">{{ __('You don\'t have any upcoming deliveries') }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex">
                                        <a href="/account/producer/{{ $producer->id }}/deliveries" class="rc">
                                            <h4 class="d-inline-block my-1 font-weight-light">{{ __('Next delivery') }}</h4>
                                        </a>
                                        <a href="#" class="black-54 box-shadow btn btn-primary ml-auto my-auto">Picklist / receipt</a>
                                    </div>

                                    <h5 class="mt-1">Bygdens Saluhall Röstånga - {{ $producer->getNextOrderDate()->date('Y-m-d') }}</h5>
                                    @php
                                        $items = [];
                                    @endphp
                                    @foreach ($producer->getNextOrderDate()->orderDateItemLinks(null, $producer->id) as $orderDateItemLink)
                                        @php
                                            $item = array(
                                                [
                                                'tr'    => __('Order'),
                                                'tr_class' => 'w-15',
                                                'value' => strtoupper($orderDateItemLink->ref),
                                                'href'  => '/account/producer/' . $producer->id . '/order/' . $orderDateItemLink->id
                                                ],
                                                [
                                                'tr'    => __('Product'),
                                                'tr_class' => 'w-25',
                                                'value' => $orderDateItemLink->getItem()->getName(),
                                                'href'  => '/account/producer/' . $producer->id . '/orders/product/' . $orderDateItemLink->getItem()->product['id']
                                                ],
                                                [
                                                'tr'    => __('Customer'),
                                                'tr_class' => 'w-25 pr-0',
                                                'value' => $orderDateItemLink->getItem()->user['name'],
                                                'href'  => '/account/producer/' . $producer->id . '/orders/user/' . $orderDateItemLink->getItem()->user['id']
                                                ],
                                                [
                                                'tr'    => __('Quantity'),
                                                'value' => $orderDateItemLink->quantity,
                                                ],
                                                [
                                                'tr'    => __('Total cost'),
                                                'tr_class' => 'w-15',
                                                'value' => $orderDateItemLink->getPrice()
                                                ],
                                            );
                                            array_push($items, $item);
                                        @endphp
                                    @endforeach
                                    <div class="overflow-scroll dashboard-upcoming-deliveries">
                                        @include('new.components.table', [
                                            'items'         => $items,
                                            'table_classes' => 'table-striped table-hover'
                                        ])
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5">
                    <div class="row">
                        <div class="col-16">
                            <div class="producer-products-list-container">
                                <div class="d-flex">
                                    <a href="/account/producer/{{ $producer->id }}/products" class="rc"><h4>{{ __('My products') }}</h4></a>

                                    <a href="/account/producer/{{ $producer->id }}/product/create" title="{{ __('Create new product') }}" class="rounded-circle box-shadow-square btn btn-sm btn-primary my-auto ml-auto">
                                        <i class="fa fa-plus black-54" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="overflow-scroll h-100">
                                    <div class="producer-products-list">
                                        <ul class="list-unstyled node-list mt-2 list-group">
                                            @foreach($producer->products() as $product)
                                                <a class="my-0 py-2 list-group-item-action" href="/account/producer/{{ $producer->id }}/product/{{ $product->id }}">
                                                    <div class="products-list-image">
                                                        <img class="box-shadow" src="{{ '/images/shutterstock_436974091.jpg' }}">
                                                    </div>
                                                    <small class="col black-87">{{ $product->name }}</small>
                                                </a>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="white-box">
                <h4>{{ __('Delivery locations') }}</h4>
                <div id="producer-map">
                    <producer-map producer-id="{{ $producer->id}}"></producer-map>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="/css/leaflet/leaflet.min.css" />
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.0/dist/leaflet.markercluster.js"></script>
    <script src="{{ mix('/js/producer-map.js') }}"></script>
@endsection

