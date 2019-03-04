@extends('new.account.layout',
[
    'sub_nav'        => 'producer',
    'sub_nav_active' => 2,
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')
    <div class="nm bg-shell">
        <div class="container pt-2">
            {{-- Nodes --}}
            <div class="white-box">
                <div id="accordion">
                    <h5 class="rc mb-4">{{ __('Nodes') }}</h5>
                    <form class="white-box" method="post" action="{{ route('account_product_deliveries_update', ['producerId' => $producer->id, 'productId' => $product->id]) }}">
                        @csrf()
                        @foreach($nodes as $node)
                            @include('new.account.product.delivery-dates.collapse-card', [
                                'place'   => $node,
                                'dates'   => $node->getDeliveryDates($product)
                            ])
                        @endforeach
                        @include('new.components.forms.submit')
                    </form>
                </div>
            </div>

            {{-- Farm delivery --}}
            <div class="white-box">
                <div id="accordion">
                    <h5 class="rc mb-4">{{ __('Farm delivery') }}</h5>
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
                    <h5 class="rc mb-4">{{ __('Home delivery') }}</h5>
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



