@extends('new.account.layout',
[
    'sub_nav' => 'account',
    'sub_nav_active' => 2
])

@section('title', trans('public/nav.my_profile'))

@section('content')
    <div class="bg-shell">
        <div class="container nm pt-2">

            <div class="row">
                <div class="col-16 col-lg-8">
                    <div class="white-box">
                        <ul class="no-bullets">
                            <li><h4 class="rc">{{ $orderItem->producer['name'] }}</h4></li>
                            <li><a href="mailto:{{ $orderItem->producer['email'] }}">{{ $orderItem->getProducer()['email'] }}</a></li>
                            <li>{{ $orderItem->getProducer()['address'] }}</li>
                            <li>{{ $orderItem->getProducer()['zip'] }} {{ $orderItem->getProducer()['city'] }}</li>
                        </ul>
                    </div>
                </div>

                <div class="col-16 col-lg-8">
                    <div class="white-box">
                        <ul class="no-bullets">
                            <li><h4 class="rc">{{ $orderItem->node['name'] }}</h4></li>
                            <li><a href="mailto:{{ $orderItem->node['email'] }}">{{ $orderItem->node['email'] }}</a></li>
                            <li>{{ $orderItem->node['address'] }}</li>
                            <li>{{ $orderItem->node['zip'] }} {{ $orderItem->node['city'] }}</li>
                        </ul>
                    </div>
                </div>

                <div class="col-16">
                    <div class="white-box">
                        <h4 class="rc">{{ trans('admin/user.payment_information') }}</h4>
                        {{ $orderItem->getProducer()['payment_info'] }}
                        {{ $orderItem->product['payment_info'] }}
                    </div>
                </div>
            </div>

            <div class="white-box mb-5">
                <h4 class="mt-1 rc">{{ trans('admin/user.order') }} #{{ $orderDateItemLink->ref }}</h4>

                @php
                    $items = [];
                @endphp

                @php
                    $item = array(
                        [
                            'tr'    => trans('admin/user.delivery'),
                            'value' => $orderDateItemLink->getDate() ? $orderDateItemLink->getDate()->date('Y-m-d') : '',
                        ],
                        [
                            'tr'    => trans('admin/user.product'),
                            'value' => $orderItem->getName(),
                        ],
                        [
                            'tr'    => trans('admin/user.quantity'),
                            'value' => $orderDateItemLink->quantity,
                        ],
                        [
                            'tr'    => trans('admin/user.price'),
                            'value' => $orderItem->getPriceWithUnit()
                        ],
                        [
                            'tr'    => trans('admin/user.total'),
                            'value' => $orderDateItemLink->getPriceWithUnit()
                        ],
                    );
                    array_push($items, $item);
                @endphp

                @include('new.components.table',
                    [
                        'items'         => $items,
                        'table_classes' => ''
                    ])

                <div class="">
                    @foreach ($orderItem->allAvailableOrderStatuses() as $orderStatus)
                        <span class="{{ $orderStatus->getHtmlClass() }}">{{ $orderStatus }}</span>
                    @endforeach

                    <div class="float-right">
                        @if ($orderDateItemLink->isDeletable())
                            <a href="/account/user/order/{{ $orderDateItemLink->id }}/delete" class="btn btn-danger">{{ trans('admin/user.delete_order') }}</a>
                        @else
                            <button class="btn btn-danger" disabled="disabled">{{ trans('admin/user.delete_order') }}</button>
                        @endif
                    </div>
                </div>
            </div>

            <p>{{ $orderItem->message }}</p>



        </div>
    </div>
@endsection

