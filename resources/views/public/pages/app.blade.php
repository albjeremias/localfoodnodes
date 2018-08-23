@extends('public.layout-page', [
    'header' => trans('public/pages/app.header'),
    'subHeader' => trans('public/pages/app.sub_header'),
    'image' => '/images/app-header.jpg'
])

@section('title', trans('public/pages/app.title'))

@section('page-content')
    <div class="container top-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body body-text">
                        <div class="row mb-5 text-center text-lg-right">
                            <div class="col-12">
                                <a target="_blank" href="https://itunes.apple.com/us/app/local-food-app/id1400957388"><img src="/images/app-store-ios.png"></a>
                                <a target="_blank" href="https://play.google.com/store/apps/details?id=org.localfoodnodes.localfoodapp"><img src="/images/app-store-android.png"></a>
                            </div>
                        </div>
                        <div class="text-center mb-5">
                            <img src="/images/app-map.png" style="height: 400px; width: auto;" />
                            <img src="/images/app-products.png" style="height: 400px; width: auto;" />
                            <img src="/images/app-orders.png" style="height: 400px; width: auto;" />
                        </div>
                        {!! trans('public/pages/app.content_top') !!}
                        {!! trans('public/pages/app.content_bottom') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
