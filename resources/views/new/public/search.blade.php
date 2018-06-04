<?php $viewName = 'search' ?>
@extends('new.public.layout')

@section('title', trans('public/index.title'))

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
        <i class="fa fa-sort-amount-desc icon my-auto float-right" aria-hidden="true"></i>

        <div class="my-4">
            @include('new.components.table')
        </div>
    </div>
@endsection
