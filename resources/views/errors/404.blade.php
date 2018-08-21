@extends('public.layout')

@section('title', trans('public/404.title'))

@section('content')

    <div class="shop-header">
        <div class="top">
            <div class="d-flex justify-content-between">
                <h3 class="bold"><i class="fa fa-warning"></i> {!! trans('public/404.title') !!}</h3>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <?php $jsonTrans = ''; ?>
        <div class="node-map" id="node-map-component-root" data-ip="{{ Request::ip() }}" data-trans="{{ $jsonTrans }}"></div>
    </div>

    <link rel="stylesheet" href="/css/leaflet/leaflet.min.css" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.0.3/dist/leaflet.markercluster.js"></script>
    <script src="/js/node-map.js"></script>
@endsection
