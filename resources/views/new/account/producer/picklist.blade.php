@extends('new.account.layout',
[
    'bread_type'   => trans('public/nav.admin'),
    'bread_result' => trans('public/nav.create_producer'),
    'nav_active'   => 1
])

@section('title', __('Picklist'))

@section('content')
    <div class="nms">
        PICKLIST / RECIPE
    </div>
@endsection
