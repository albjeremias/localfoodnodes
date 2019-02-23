@extends('new.account.layout',
[
    'sub_nav'        => 'producer',
    'sub_nav_active' => 1,
    'nav_active'     => 1
])

@section('title', 'Dashboard')
@section('content')
    <div class="container nm py-5">
        <h2>{{ __('Stock and variants') }}</h2>
        <div id="stock-and-variants">
            <stock-and-variants lang="{{ app()->getLocale() }}" producer-id="{{ $producer->id }}" product-id="{{ $product->id }}"></stock-and-variants>
        </div>
    </div>
    <script src="{{ mix('js/stock-and-variants.js') }}"></script>
@endsection



