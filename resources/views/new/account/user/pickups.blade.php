@extends('new.account.layout',
[
    'nav_title' => trans('admin/user.nav_title'),
    'sub_nav' => 'account',
    'nav_active' => 0,
    'sub_nav_active' => 2
])

@section('title', trans('public/nav.my_profile'))

@section('content')
    <div class="bg-shell">
        <div class="container nm pt-2">
            @if ($user->orderDates()->count() > 0)
                @foreach ($user->orderDates() as $orderDate)
                    <div class="white-box mb-5">
                        <h4 class="mt-1 rc pl-2">{{ __('Pickup') }} {{ $orderDate->date('Y-m-d') }}</h4>

                        @php
                            $items = [];
                        @endphp

                        @foreach ($orderDate->orderDateItemLinks($user->id) as $orderDateItemLink)
                            @php
                                $item = array(
                                    [
                                        'tr'    => __('Order'),
                                        'value' => $orderDateItemLink->ref,
                                        'href'  => '/account/user/order/' . $orderDateItemLink->id
                                    ],
                                    [
                                        'tr'    => __('Product'),
                                        'tr_class' => 'w-25',
                                        'value' => $orderDateItemLink->getItem()->getName(),
                                        'href'  => '/account/user/orders/product/' . $orderDateItemLink->getItem()->product_id
                                    ],
                                    [
                                        'tr'    => __('Quantity'),
                                        'value' => $orderDateItemLink->quantity,
                                    ],
                                    [
                                        'tr'    => __('Producer'),
                                        'tr_class' => 'w-25',
                                        'value' => $orderDateItemLink->getItem()->producer['name'],
                                        'href'  => '/account/user/orders/producer/' . $orderDateItemLink->producer_id
                                    ],
                                    [
                                        'tr'    => __('Node'),
                                        'tr_class' => 'w-20',
                                        'value' => $orderDateItemLink->getItem()->node['name'],
                                    ],
                                    [
                                        'tr'    => __('Price'),
                                        'tr_class' => 'w-15',
                                        'value' => $orderDateItemLink->getPriceWithUnit()
                                    ],
                                    [
                                        'tr'    => __('Status'),
                                        'tr_class' => 'pt-2',
                                        'badge' => true,
                                        'value' => $orderDateItemLink->getItem()->getCurrentStatus(),
                                        'class' => $orderDateItemLink->getItem()->getCurrentStatus()->getHtmlClass()
                                    ]
                                );
                                array_push($items, $item);
                            @endphp
                        @endforeach

                        @include('new.components.table',
                            [
                                'items'         => $items,
                                'table_classes' => ''
                            ])
                    </div>
                @endforeach
            @else
                {{ __('No orders') }}
            @endif
        </div>
    </div>
@endsection

