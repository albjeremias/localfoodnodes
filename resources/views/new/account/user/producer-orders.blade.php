@extends('new.account.layout',
[
    'sub_nav' => 'account',
    'sub_nav_active' => 2
])

@section('title', trans('public/nav.my_profile'))

@section('content')
    <div class="bg-shell">
        <div class="container nm pt-2">
            <div class="white-box mb-5">
                <h4 class="mt-1 rc pl-2">{{ $orderDateItemLinks->first()->getItem()->product['name'] }}</h4>

                @php
                    $items = [];
                @endphp

                @foreach ($orderDateItemLinks as $orderDateItemLink)
                    @php
                        $item = array(
                            [
                                'tr'    => trans('admin/producer.order'),
                                'value' => $orderDateItemLink->ref,
                                'href'  => '/account/producer/' . $orderDateItemLink->producer_id . '/order/' . $orderDateItemLink->getItem()->product_id
                            ],
                            [
                                'tr'    => trans('admin/producer.product'),
                                'value' => $orderDateItemLink->getItem()->getName(),
                            ],
                            [
                                'tr'    => trans('admin/producer.quantity'),
                                'class' => 'text-right',
                                'value' => $orderDateItemLink->quantity,
                            ],
                            [
                                'tr'    => trans('admin/producer.node'),
                                'value' => $orderDateItemLink->getItem()->node['name'],
                            ],
                            [
                                'tr'    => trans('admin/producer.delivery'),
                                'value' => $orderDateItemLink->getDate() ? $orderDateItemLink->getDate()->date('Y-m-d') : '',
                            ],
                            [
                                'tr'    => trans('admin/producer.total_price'),
                                'tr_class' => 'w-15',
                                'value' => $orderDateItemLink->getPriceWithUnit()
                            ],
                            [
                                'tr'    => trans('admin/producer.status'),
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
        </div>
    </div>
@endsection

