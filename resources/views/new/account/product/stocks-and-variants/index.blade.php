@extends('new.account.layout',
[
    'nav_title'      => trans('admin/user.nav_title'),
    'sub_nav'        => 'producer',
    'sub_nav_active' => 1,
    'nav_active'     => 1
])

@section('title', 'Dashboard')
@section('content')
    <div id="stock-and-variants">
        <stock-and-variants lang="{{ app()->getLocale() }}" producer-id="{{ $producer->id }}" product-id="{{ $product->id }}"></stock-and-variants>
    </div>
    <script src="{{ mix('js/stock-and-variants.js') }}"></script>
@endsection



