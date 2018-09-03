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
                                <img src="/images/team/placeholder.png" class="rounded-circle " />
                                <div class="mt-3">
                                    <b>Albin Ponnert</b><br/>
                                    {{ trans('public/pages/team.albinponnert_title') }}
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                {{ trans('public/pages/team.albinponnert') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body body-text">
                        <div class="row">
                            <div class="col-12 col-md-3 text-center mb-5">
                                <img src="/images/team/placeholder.png" class="rounded-circle" />
                                <div class="mt-3">
                                    <b>Alexander Frödeberg</b><br/>
                                    {{ trans('public/pages/team.alexanderfrodeberg_title') }}
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                {{ trans('public/pages/team.alexanderfrodeberg') }}
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
