@extends('new.account.layout',
[
    'nav_title'      => trans('admin/user.nav_title'),
    'sub_nav'        => 'producer',
    'sub_nav_active' => 1,
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')
    <div class="nms bg-shell">

        {{-- PLACEHOLDER - Will be replaced when we store selected producer in session. @NOTE David --}}
        @foreach ($user->producerAdminLinks() as $producerAdminLink)
            @php
                $active_producer_id = $producerAdminLink->getProducer()->id;
            @endphp
        @endforeach

        <div class="container py-5">
            <div class="row">
                <div class="col-16">
                    <div class="white-box">
                        <h3 class="text-center mb-3">{{ $product->name }}</h3>
                        <p>
                            På denna sida kan du göra flera och mer detaljerade inställningar som passar för denna produkt.
                            Du når alltid denna vy närsomhelst för varje enskild produkt i din produktvy.
                        </p>
                        <div class="d-flex">
                            <a class="btn btn-primary mx-auto" href="{{ '/account/producer/' . $active_producer_id . '/products' }}">{{ trans('admin/user-nav.products') }}</a>
                        </div>
                    </div>
                </div>

                @include('new.account.product.settings.basic-info')

                @include('new.account.product.settings.stocks-and-variants')

                @include('new.account.product.settings.delivery-dates')

                @include('new.account.product.settings.meat-box')
            </div>

        </div>
    </div>
@endsection

