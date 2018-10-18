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
                        <h4 class="mt-1 rc pl-2">{{ trans('admin/user.pickup') }} {{ $orderDate->date('Y-m-d') }}</h4>

                        @php
                            $items = [];
                        @endphp

                        @foreach ($orderDate->orderDateItemLinks($user->id) as $orderDateItemLink)
                            @php
                                $item = array(
                                    [
                                        'tr'    => trans('admin/user.order'),
                                        'value' => $orderDateItemLink->ref,
                                        'href'  => '/account/user/order/' . $orderDateItemLink->id
                                    ],
                                    [
                                        'tr'    => trans('admin/user.product'),
                                        'tr_class' => 'w-25',
                                        'value' => $orderDateItemLink->getItem()->getName(),
                                        'href'  => '/account/user/orders/product/' . $orderDateItemLink->getItem()->product_id
                                    ],
                                    [
                                        'tr'    => trans('admin/user.quantity'),
                                        'value' => $orderDateItemLink->quantity,
                                    ],
                                    [
                                        'tr'    => trans('admin/user.producer'),
                                        'tr_class' => 'w-25',
                                        'value' => $orderDateItemLink->getItem()->producer['name'],
                                        'href'  => '/account/user/orders/producer/' . $orderDateItemLink->producer_id
                                    ],
                                    [
                                        'tr'    => trans('admin/user.node'),
                                        'tr_class' => 'w-20',
                                        'value' => $orderDateItemLink->getItem()->node['name'],
                                    ],
                                    [
                                        'tr'    => trans('admin/user.price'),
                                        'tr_class' => 'w-15',
                                        'value' => $orderDateItemLink->getPriceWithUnit()
                                    ],
                                    [
                                        'tr'    => trans('admin/user.status'),
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
                {{ trans('admin/user.no_orders') }}
            @endif
        </div>
    </div>
@endsection

