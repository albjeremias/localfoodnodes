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
        <div class="container nm">
            @if ($producer->orderDates()->count() > 0)
                @foreach ($producer->orderDates() as $orderDate)
                    <div class="white-box mb-5">
                        <h4 class="mt-1 rc pl-2">{{ trans('admin/user.pickup') }} {{ $orderDate->date('Y-m-d') }}</h4>

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
                                'tr'    => trans('admin/producer.order'),
                                'value' => strtoupper($orderDateItemLink->ref),
                                'href'  => '/account/producer/' . $producer->id . '/order/' . $orderDateItemLink->id
                                ],
                                [
                                'tr'    => trans('admin/producer.product'),
                                'tr_class' => 'w-25',
                                'value' => $orderDateItemLink->getItem()->getName(),
                                'href'  => '/account/producer/' . $producer->id . '/orders/product/' . $orderDateItemLink->getItem()->product['id']
                                ],
                                [
                                'tr'    => trans('admin/producer.customer'),
                                'value' => $orderDateItemLink->getItem()->user['name'],
                                'href'  => '/account/producer/' . $producer->id . '/orders/user/' . $orderDateItemLink->getItem()->user['id']
                                ],
                                [
                                'tr'    => trans('admin/producer.quantity'),
                                'value' => $orderDateItemLink->quantity,
                                ],
                                [
                                'tr'    => trans('admin/producer.node'),
                                'value' => $orderDateItemLink->getItem()->node['name'],
                                ],
                                [
                                'tr'    => trans('admin/producer.total_price'),
                                'value' => $orderDateItemLink->getPriceWithUnit()
                                ],
                                [
                                'tr'    => trans('admin/producer.status'),
                                'badge' => true,
                                'value' => $orderDateItemLink->getItem()->getCurrentStatus(),
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

