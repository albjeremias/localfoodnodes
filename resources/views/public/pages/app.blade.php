@extends('public.layout-page', [
    'header' => trans('public/pages/app.header'),
    'subHeader' => trans('public/pages/app.sub_header'),
    'image' => '/images/shutterstock_326785574.jpg'
])

@section('title', trans('public/pages/app.title'))

@section('page-content')
    <div class="container top-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body body-text">
                        {!! trans('public/pages/app.content_top') !!}
                        <div class="text-center mb-5">
                            <img src="/images/app-map.png" style="height: 400px; width: auto;" />
                            <img src="/images/app-products.png" style="height: 400px; width: auto;" />
                            <img src="/images/app-orders.png" style="height: 400px; width: auto;" />
                        </div>
                        {!! trans('public/pages/app.content_bottom') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
