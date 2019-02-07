@extends('new.account.layout',
[
    'bread_type'   => trans('public/nav.admin'),
    'bread_result' => trans('public/nav.create_producer'),
    'nav_active'   => 1
])

@section('title', trans('public/register.title_producer'))

@section('content')
    <div class="nms">
        @include('new.components.progress',
            [
                'active' => 2,
                'steps'  =>
                    [
                        __('Read terms'),
                        __('Create account'),
                        __('Sale channels'),
                        __('Finish')
                    ]
            ])
        <div class="container py-5">
            <h2>{{  __('Choose your sale channels here') }}</h2>
            <p>{{ __('Choose which channels you want to sell your products through.') }}<br>{{ __('You can at any time reach and update your sales channels settings from your producer dashboard.') }}</p>

            <div class="mt-5 pl-2">
                {{-- Local Food Nodes --}}
                <div class="form-check custom-control custom-checkbox custom-checkbox-lg">
                    <input name="lfn" class="custom-control-input" checked disabled type="checkbox" value="" id="checkbox-lfn">
                    <label class="custom-control-label" for="checkbox-lfn">
                        <h4 class="d-inline-block mb-0 bc">Local Food Nodes</h4>
                        @include('new.components.info', [
                            'text' => __('This setting is default and cannot be unchoosen. It makes you able to connect to any local food node on the map. You find all nodes in the ”Attach to local food nodes” map below.'),
                            'placement' =>
                            'right',
                            'class' => 'bc'
                        ])
                    </label>
                </div>

                {{-- Farm delivery --}}
                <div class="form-check mt-4 custom-control custom-checkbox custom-checkbox-lg">
                    <input name="farm-delivery" class="custom-control-input" type="checkbox" value="" id="checkbox-farm-delivery">
                    <label class="custom-control-label" for="checkbox-farm-delivery">
                        <h4 class="d-inline-block mb-0">{{ __('Farm delivery') }}</h4>
                        @include('new.components.info', [
                            'text' => __('This feature makes it possible for you to create delivery dates and use you farm location as a pick up spot for your products.'),
                            'placement' => 'right'
                        ])
                    </label>
                </div>

                {{-- Home delivery --}}
                <div class="form-check mt-4 custom-control custom-checkbox custom-checkbox-lg">
                    <input name="home-delivery" class="custom-control-input" disabled type="checkbox" value="" id="checkbox-home-delivery">
                    <label class="custom-control-label" for="checkbox-home-delivery">
                        <h4 class="d-inline-block mb-0">{{ __('Home delivery') }}</h4>
                        <small class="font-italic"> - Not yet available</small>
                    </label>
                </div>

                {{-- Shipping --}}
                <div class="form-check mt-4 custom-control custom-checkbox custom-checkbox-lg">
                    <input name="shipping" class="custom-control-input" disabled type="checkbox" value="" id="checkbox-shipping">
                    <label class="custom-control-label" for="checkbox-shipping">
                        <h4 class="d-inline-block mb-0">{{ __('Shipping') }}</h4>
                        <small class="font-italic"> - Not yet available</small>
                    </label>
                </div>
            </div>

            <div class="mt-5">
                <h4>{{  __('Attach to Local Food Nodes') }}</h4>
                <p>{{ __('Choose which Local Food Nodes you want to attach your producer account to.') }}</p>
                DAVID - KARTA GOES HERE
            </div>
        </div>
    </div>
@endsection
