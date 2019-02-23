@extends('new.account.layout',
[
    'sub_nav'        => 'producer',
    'sub_nav_active' => 2,
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')
    <div class="bg-shell">
        <div class="container nm pt-3">
            <div class="d-flex">
                <h2 class="d-inline-block">Upcoming</h2>
                <a href="#" class="btn btn-secondary box-shadow my-auto ml-auto">{{ __('Switch to Expired') }}</a>
            </div>
            @if ($producer->orderDates()->count() > 0)
                @foreach ($producer->orderDates()->reverse() as $orderDate)
                    <div class="white-box mb-5">
                        <h4 class="mt-1 bc pl-2">{{ __('Deliveries') }} {{ $orderDate->date('Y-m-d') }}</h4>
                        @php
                            $items = [];
                        @endphp
                        @foreach ($orderDate->orderDateItemLinks(null, $producer->id) as $orderDateItemLink)
                            @php
                                $item = array(
                                    [
                                    'tr'    => __('Order'),
                                    'tr_class' => 'w-10',
                                    'value' => strtoupper($orderDateItemLink->ref),
                                    'href'  => '/account/producer/' . $producer->id . '/order/' . $orderDateItemLink->id
                                    ],
                                    [
                                    'tr'    => __('Product'),
                                    'tr_class' => 'w-50',
                                    'value' => $orderDateItemLink->getItem()->getName(),
                                    'href'  => '/account/producer/' . $producer->id . '/orders/product/' . $orderDateItemLink->getItem()->product['id']
                                    ],
                                    [
                                    'tr'    => __('Customer'),
                                    'tr_class' => 'w-15 pr-0',
                                    'value' => $orderDateItemLink->getItem()->user['name'],
                                    'href'  => '/account/producer/' . $producer->id . '/orders/user/' . $orderDateItemLink->getItem()->user['id']
                                    ],
                                    [
                                    'tr'    => __('Quantity'),
                                    'value' => $orderDateItemLink->quantity,
                                    ],
                                    [
                                    'tr'    => __('Total cost'),
                                    'tr_class' => 'w-10',
                                    'value' => $orderDateItemLink->getPrice()
                                    ],
                                );
                            array_push($items, $item);
                            @endphp
                        @endforeach
                        @include('new.components.table', [
                            'items'         => $items,
                            'table_classes' => ''
                        ])
                        <div class="d-flex">
                            <a href="#" class="box-shadow btn btn-primary ml-auto">Picklist / receipt</a>
                        </div>
                    </div>
                @endforeach
            @else
                {{ trans('admin/producer.no_upcoming_deliveries') }}
            @endif
        </div>
    </div>
@endsection

