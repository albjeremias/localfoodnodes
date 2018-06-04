@extends('new.public.layout',
[
    'bread_type'     => 'Sökresultat',
    'bread_result'   => $node->name,
    'sub_nav'        => ['Produkter', 'Kalender', 'Producenter', 'Bilder'],
    'sub_nav_active' => 0,
]
)

@section('title', $node->name)

@section('content')

    <div class="bg-shell">
        <div class="bg-img-calves image node-background"></div>

        <div class="node-info container wc nm">
            <div class="row">
                <div class="col-16">
                    <h1>{{ $node->name }}</h1>

                    <ul class="list-inline pt-2">
                        <li class="list-inline-item mr-4">
                            <a class="btn btn-primary" href="#">GÅ MED I NOD</a>
                        </li>

                        <li class="list-inline-item mr-4 d-block d-md-inline-block mt-2 mt-md-0">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            {{ $node->address }}, {{ $node->zip }} {{ $node->city }}
                        </li>

                        <li class="list-inline-item">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            {{ trans('public/index.' . $node->delivery_weekday) }},
                            {{ $node->delivery_time }},
                            {{ $node->delivery_interval }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <section id="filter-info">
            <div class="container">
                <div class="row mt-4">
                    <div class="col-16 col-xl-10">
                        <div class="filter">
                            <h4 class="mb-0">Boka produkter</h4>
                            <small>Markera för att filtrera och sortera dina resultat</small>

                            <div class="mt-3">
                                <a href="#" class="badge badge-info bc bb">Markera alla</a>
                                @foreach ($tags as $label => $tag)
                                    @if ($tag['active'])
                                        <a href="{{ $tag['url'] }}" class="badge badge-danger"><small class="rc">{{ $label }}</small></a>
                                    @else
                                        <a href="{{ $tag['url'] }}" class="badge badge-light"><small class="black-87">{{ $label }}</small></a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-16 col-xl-6 mt-5 mt-xl-0">
                        <div class="info">
                            <h4 class="mb-0">Information</h4>
                            <small>Om {{ $node->name }}</small>

                            <div class="row mt-3">
                                <div class="col-16 col-sm-4 col-lg-3 col-xl-4">
                                    <h4 class="mb-0">1129</h4>
                                    <small>Användare</small>
                                </div>

                                <div class="col-16 col-sm-4 col-lg-3 col-xl-4">
                                    <h4 class="mb-0">41</h4>
                                    <small>Producenter</small>
                                </div>

                                <div class="col-16 col-sm-8 col-lg-3 col-xl-8">
                                    <h4 class="mb-0">13.5 km</h4>
                                    <small>Snittavstånd till producent</small>
                                </div>
                            </div>

                            <p class="mt-4">
                                <i class="fa fa-facebook-square icon" aria-hidden="true"></i>
                                <span class="ml-3">Hitta till vår <a href="#">kommunikationsgrupp</a></span>
                            </p>

                            <p>
                                <i class="fa fa-envelope icon" aria-hidden="true"></i>
                                <span class="ml-3">Kontakta nodadmin på <a href="#">zaunders@gmail.com</a></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container my-4">
            <div class="dropdown">
                <i class="fa fa-calendar icon" aria-hidden="true"></i>
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    VÄLJ UTLÄMNINGSDATUM
                </button>
                <div class="dropdown-menu">

                    @foreach ($node->getDeliveryDatesWithProducts() as $deliveryDate)
                        @if (Request::input('date') === $deliveryDate)
                            <a href="{{ $node->permalink()->url }}?date={{ $deliveryDate }}"
                               class="dropdown-item">{{ $deliveryDate }}</a>
                        @else
                            <a href="{{ $node->permalink()->url }}?date={{ $deliveryDate }}"
                               class="dropdown-item">{{ $deliveryDate }}</a>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>

        <!-- PRODUCTS -->
        <section class="mb-5">
            @if ($products->count() > 0)
                <div class="container">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-16 col-sm-8 col-lg-4 mb-3">
                                @include('new.components.cards.product')
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>
    </div>
@section('modal')
    @if (Session::has('added_to_cart_modal'))
        <div class="modal fade" id="added-to-cart-modal" tabindex="-1" role="dialog" data-backdrop="static"
             data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body body-text">
                        <div class="row">
                            <div class="col-6">
                                <a href="#" class="choice continue-shopping"
                                   data-dismiss="modal">{{ trans('public/checkout.continue_shopping') }}</a>
                            </div>
                            <div class="col-6">
                                <a href="/checkout"
                                   class="choice go-to-checkout">{{ trans('public/checkout.go_to_checkout') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#added-to-cart-modal').modal('show');
        </script>
    @endif
@endsection
