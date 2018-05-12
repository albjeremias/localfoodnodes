@extends('public.layout-page', [
    'header' => trans('public/pages/gdpr.header'),
    'subHeader' => trans('public/pages/gdpr.subheader'),
    'image' => '/images/cows-bw.jpg'
])

@section('title', trans('public/pages/gdpr.header'))

@section('page-content')
    <div class="container top-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body body-text">
                        {!! trans('public/pages/gdpr.content') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
