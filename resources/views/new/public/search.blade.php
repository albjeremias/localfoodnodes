@extends('new.public.layout',
[
    'sub_nav' => 'explore',
]
)

@section('title', trans('public/pages/explore.title'))

@section('content')

    <div class="container-fluid nms">
        <section class="medium-min bg-accent-light-24 d-flex">
            <div class="row justify-content-center align-self-center mx-auto">
                @include('new.components.cards.node',
                [
                    'name'      => 'Dalby Saluhall',
                    'address'   => 'Dalbysaluhallväg 1, 21144 Dalby',
                    'bio'       => 'Välkommen att handla i Byggdens Saluhall Dalby',
                    'time'      => 'Tis, 12:00',
                    'producers' => '12',
                    'link'      => '/node/bygdens-saluhall-billinge'
                ])
            </div>
        </section>
    </div>

    <div class="container my-3">

        <span class="h3">"Skåne"</span>
        <i class="fa fa-sort-amount-desc icon-38 my-auto float-right" aria-hidden="true"></i>

        <div class="my-4">


            @php
                $items = [
                    [
                        'type'                                          => 'map-marker',
                        trans('public/pages/explore.name')              => 'Bygdens Saluhall Dalby',
                        trans('public/pages/explore.distance_from_you') => '100 km',
                        trans('public/pages/explore.address')           => 'Pumpavägen 1, 24750, Dalby',
                        trans('public/pages/explore.open')              => 'Onsdagar, 18:30',
                    ]
                ]
            @endphp

            @include('new.components.table',
                [
                    'items' => $items
                ]
            )
        </div>
    </div>
@endsection
