@extends('public.layout-page', [
    'header' => trans('public/pages/team.header'),
    'subHeader' => trans('public/pages/team.subheader'),
    'image' => '/images/money-ladder.jpg'
])

@section('title', trans('public/pages/team.title'))

@section('page-content')
    <div class="container top-container">
        <div class="row justify-content-center">
            <div class="col-12">

                <div class="card">
                    <div class="card-body body-text">
                        <div class="row">
                            <div class="col-12 col-md-3 text-center mb-5">
                                <img src="/images/team/albinponnert.jpg" class="rounded-circle " />
                                <div class="mt-3">
                                    <b>Albin Ponnert</b><br/>
                                    <div>{{ trans('public/pages/team.albinponnert_title') }}</div>
                                    <div><a href="mailto:albin@ponnert.se">albin@ponnert.se</a></div>
                                    <div><a href="tel:0046735325945">073 - 532 59 45</a></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                {!! trans('public/pages/team.albinponnert') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body body-text">
                        <div class="row">
                            <div class="col-12 col-md-3 text-center mb-5">
                                <img src="/images/team/alexanderfrodeberg.jpg" class="rounded-circle" />
                                <div class="mt-3">
                                    <b>Alexander Frödeberg</b><br/>
                                    {{ trans('public/pages/team.alexanderfrodeberg_title') }}
                                    <a href="mailto:info@localfoodnodes.org">info@localfoodnodes.org</a>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                {!! trans('public/pages/team.alexanderfrodeberg') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body body-text">
                        <div class="row">
                            <div class="col-12 col-md-3 text-center mb-5">
                                <img src="/images/team/davidajnered.jpg" class="rounded-circle" />
                                <div class="mt-3">
                                    <b>David Ajnered</b><br/>
                                    {{ trans('public/pages/team.davidajnered_title') }}
                                    <a href="mailto:david@localfoodnodes.org">david@localfoodnodes.org</a>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                {!! trans('public/pages/team.davidajnered') !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
