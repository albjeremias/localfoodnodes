@extends('new.account.layout',
[
    'nav_title'      => trans('admin/user.nav_title'),
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')
    <div class="nms bg-shell">

        @include('new.components.progress',
        [
        'active' => 1,
        'steps'  =>
            [
                trans('admin/producer.product'),
                trans('admin/producer.production'),
                trans('admin/producer.delivery_dates'),
                trans('admin/producer.variants')
            ]
        ])

        {{-- PLACEHOLDER - Will be replaced when we store selected producer in session. @NOTE David --}}
        @foreach ($user->producerAdminLinks() as $producerAdminLink)
            @php
                $active_producer_id = $producerAdminLink->getProducer()->id;
            @endphp
        @endforeach

        <div class="container py-5">
            <div class="white-box">
                <p>
                    På denna sida kan du göra flera och mer detaljerade inställningar som passar för denna produkt.
                    Du når alltid denna vy närsomhelst för varje enskild produkt i din produktvy.
                </p>
                <a class="btn btn-primary text-center" href="{{ '/account/producer/' . $active_producer_id . '/products' }}">{{ trans('admin/user-nav.products') }}</a>
            </div>

            @include('new.account.product.settings.basic-info')

            @include('new.account.product.settings.stocks-and-variants')

            @include('new.account.product.settings.delivery-dates')

        </div>
    </div>
@endsection

