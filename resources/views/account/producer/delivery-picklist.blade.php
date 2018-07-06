@extends('account.layout')

@section('title', join(array_keys($breadcrumbs), ' - '))

@section('content')
    @include('account.page-header')

    <div class="card pick-list">
        <div class="card-header">{{ $node['name'] }} - {{ $orderDate->date('Y-m-d') }}</div>
        <div class="card-body">
            @foreach ($orderItemsGroupedByUserId as $userId => $orderDateItemLinks)
                <div class="receipt pb-3 mb-3">
                    <div class="receipt__header mb-5 pull-left">{{ trans('admin/producer.receipt') }} - {{ $orderDateItemLinks->first()->getItem()->user['name'] }}</div>
                    <div class="pull-right mb-5">
                        <div class="receipt__header">{{ trans('admin/producer.seller') }}</div>
                        <div>{{ $producer->name }}</div>
                        <div>{{ $producer->address }}, {{ $producer->zip }} {{ $producer->city }}</div>
                        <div>{{ $producer->vat_identification_number }}</div>
                        <div>{{ trans('admin/producer.receipt_created') }} {{ date('Y-m-d') }}</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>{{ trans('admin/producer.product') }}</th>
                                <th></th>
                                <th>{{ trans('admin/producer.price') }}</th>
                                <th>{{ trans('admin/producer.quantity') }}</th>
                                <th>{{ trans('admin/producer.sum') }}</th>
                                <th>{{ trans('admin/producer.vat') }}</th>
                            </tr>
                            @foreach ($orderDateItemLinks as $orderDateItemLink)
                                <tr>
                                    <td>
                                        @if ($orderDateItemLink->getItem()->variant_id)
                                            {{ $orderDateItemLink->getItem()->getProduct()->name }}
                                            - {{ $orderDateItemLink->getItem()->getVariant()->name }}
                                            {{ $orderDateItemLink->getItem()->getVariant()->getPackageAmountUnit() }}
                                        @else
                                            {{ $orderDateItemLink->getItem()->getProduct()->name }}
                                            {{ $orderDateItemLink->getItem()->getProduct()->getPackageAmountUnit() }}
                                        @endif
                                    </td>
                                    <td>{{ $orderDateItemLink->getItem()->message }}</td>
                                    <td>{{ $orderDateItemLink->getItem()->getPriceWithUnit() }}</td>
                                    <td>{{ $orderDateItemLink->quantity }}</td>
                                    <td>{!! $orderDateItemLink->getPriceWithUnit() !!}</td>
                                    <td>
                                        @if ($orderDateItemLink->getItem()->getProduct()->vat)
                                            {{ $orderDateItemLink->getVatAmountWithUnit() }}
                                            ({{ $orderDateItemLink->getItem()->getProduct()->vat }}%)
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="receipt__total">
                        <div class="receipt__total__label">{{ trans('admin/producer.total') }}:</div>
                        <div class="receipt__total__amount">
                            {{
                                number_format($orderDateItemLinks->sum(function($orderDateItemLink) {
                                    if ($orderDateItemLink->getItem()->variant) {
                                        $price = $orderDateItemLink->getItem()->getVariant()->price;
                                    } else {
                                        $price = $orderDateItemLink->getItem()->getProduct()->price;
                                    }

                                    return $price * $orderDateItemLink->quantity;
                                }), 2, '.', ' ')
                            }} {{ $orderDateItemLinks->first()->getItem()->getProducer()->currency }}
                        </div>

                        <div class="receipt__total__label">{{ trans('admin/producer.vat') }}:</div>
                        <div class="receipt__total__amount">
                            {{
                                $orderDateItemLinks->sum(function($orderDateItemLink) {
                                    if ($orderDateItemLink->getItem()->variant) {
                                        $price = $orderDateItemLink->getItem()->getVariant()->price;
                                    } else {
                                        $price = $orderDateItemLink->getItem()->getProduct()->price;
                                    }

                                    return $price * $orderDateItemLink->quantity * ($orderDateItemLink->getItem()->getProduct()->vat / 100);
                                })
                            }} {{ $orderDateItemLinks->first()->getItem()->producer['currency'] }}
                        </div>
                    </div>
                </div>
            @endforeach

            <button class="btn btn-success" onClick="window.print(); return false">{{ trans('admin/producer.print') }}</button>
        </div>
    </div>

    <style>
        .receipt {
            border-bottom: 1px dashed #ccc;
        }
        .receipt__header {
            font-family: 'montserrat';
            font-weight: bold;
        }
        .receipt__total {
            background: #fafafa;
            display: flex;
            font-family: 'montserrat';
            font-weight: bold;
            padding: 15px;
        }
        .receipt__total__label {
            margin-right: 1rem;
        }
        .receipt__total__amount {
            margin-right: 5rem;
        }
    </style>
@endsection
