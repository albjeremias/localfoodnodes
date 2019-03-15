@extends('new.account.layout',
[
    'nav_active'   => 1
])

@section('title', __('Sales channels'))

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

        <div class="bg-accent-light-24">
            <div class="container py-5">
                <div class="row py-4 terms_intro">
                    <div class="col-xl-8">
                        <h2>{{  __('Choose your sales channels') }}</h2>
                        <p>{{ __('Choose which channels you want to sell your products through. You can at any time reach and update your sales channels settings from your producer dashboard.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('account_producer_channels_save', ['producerId' => $producer->id]) }}" method="post" class="container pt-3 pb-5">
            @csrf()

            {{-- Local Food Nodes --}}
            <div class="form-check custom-control custom-checkbox custom-checkbox-lg">
                <input name="lfn" class="custom-control-input" checked disabled type="checkbox" value="" id="checkbox-lfn">
                <label class="custom-control-label" for="checkbox-lfn">
                    <h4 class="d-inline-block mb-0 bc">Local Food Nodes</h4>
                </label>
            </div>
            <div class="mt-2  mb-2 w-50 pl-4">
                <small>Connect to any local food node on the map.</small>
            </div>

            <div id="producer-map">
                <producer-map producer-id="{{ $producer->id}}"></producer-map>
            </div>

            {{-- Farm delivery --}}
            <div class="form-check mt-4 custom-control custom-checkbox custom-checkbox-lg">
                <input name="farm_delivery" class="custom-control-input" type="checkbox" value="true" id="checkbox-farm-delivery" {{ $producer->farm_delivery_link ? 'checked' : '' }}>
                <label class="custom-control-label" for="checkbox-farm-delivery">
                    <h4 class="d-inline-block mb-0">{{ __('Farm delivery') }}</h4>
                </label>
            </div>
            <div class="mt-2 w-50 pl-4">
                <small>Use your farm as a pick up spot and set delivery dates that works with your schedule.</small>
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

            <div class="d-flex w-100 mt-3">
                <button type="submit" class="btn btn-primary">{{  __('Back') }}</button>
                @include('new.components.forms.submit')
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="/css/leaflet/leaflet.min.css" />
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.0/dist/leaflet.markercluster.js"></script>
    <script src="{{ mix('/js/producer-map.js') }}"></script>
@endsection
