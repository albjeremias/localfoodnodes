@extends('new.account.layout',
[
    'nav_title'      => trans('admin/user.nav_title'),
    'sub_nav'        => 'producer',
    'sub_nav_active' => 1,
    'nav_active'     => 1
])

@section('title', 'Dashboard')
@section('content')
    <div class="nm bg-shell">
        <div class="container pt-2">
            {{-- Nodes --}}
            <div class="white-box">
                <div id="accordion">
                    <h5 class="mb-4">{{ trans('admin/product.nodes') }}</h5>
                    @foreach($nodes as $node)
                        @include('new.account.product.delivery-dates.collapse-card', [
                            'place'   => $node,
                            'dates'   => $node->getDeliveryDates($product)
                        ])
                    @endforeach
                </div>
            </div>

            {{-- Farm delivery --}}
            <div class="white-box">
                <div id="accordion">
                    <h5 class="mb-4">{{ trans('admin/product.farm_delivery') }}</h5>
                    @include('new.components.simple-table', [
                        'items'         => ['<span class="font-italic">Not yet available</span></li>' => ''],
                        'table_classes' => 'mb-4',
                        'bold'          => false
                    ])
                </div>
            </div>

            {{-- Home delivery --}}
            <div class="white-box">
                <div id="accordion">
                    <h5 class="mb-4">{{ trans('admin/product.home_delivery') }}</h5>
                    @include('new.components.simple-table', [
                        'items'         => ['<span class="font-italic">Not yet available</span></li>' => ''],
                        'table_classes' => 'mb-4',
                        'bold'          => false
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection



