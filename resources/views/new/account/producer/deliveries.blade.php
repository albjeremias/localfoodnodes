@extends('new.account.layout',
[
    'nav_title'      => trans('admin/user.nav_title'),
    'sub_nav'        => 'producer',
    'sub_nav_active' => 3,
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')
    <div class="bg-shell">
        <div class="container nm pt-3">
            @if ($producer->orderDates()->count() > 0)
                @foreach ($producer->orderDates() as $orderDate)
                    <div class="white-box mb-5">
                        <h4 class="mt-1 rc pl-2">{{ __('Deliveries') }} {{ $orderDate->date('Y-m-d') }}</h4>

                        @php
                            $items = [];
                        @endphp
                    @foreach ($orderDate->orderDateItemLinks(null, $producer->id) as $orderDateItemLink)
                        @php
                            $items = [];
                        @endphp
                        @php
                            $item = array(
                                [
                                'tr'    => __('Order'),
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
                                'value' => $orderDateItemLink->getItem()->user['name'],
                                'href'  => '/account/producer/' . $producer->id . '/orders/user/' . $orderDateItemLink->getItem()->user['id']
                                ],
                                [
                                'tr'    => __('Quantity'),
                                'value' => $orderDateItemLink->quantity,
                                ],
                                [
                                'tr'    => __('Node'),
                                'value' => $orderDateItemLink->getItem()->node['name'],
                                ],
                                [
                                'tr'    => __('Price'),
                                'value' => $orderDateItemLink->getPriceWithUnit()
                                ],
                                [
                                'tr'    => __('Status'),
                                'badge' => true,
                                'value' => 'Null',
                                'class' => $orderDateItemLink->getItem()->getCurrentStatus()->getHtmlClass()
                                ]
                            );
                        array_push($items, $item);
                        @endphp

                        @include('new.components.table', [
                            'items'         => $items,
                            'table_classes' => ''
                        ])
                    @endforeach
                    </div>
                @endforeach
            @else
                {{ trans('admin/producer.no_upcoming_deliveries') }}
            @endif
        </div>
    </div>
@endsection

