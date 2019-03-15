@extends('new.public.layout',
[
    'sub_nav'        => 'node',
    'nav_active'     => 0,
    'sub_nav_active' => 0,
    'node_slug'      => 'bygdens-saluhall-billinge',
    'script'         => 'consumer-product'
]
)

@section('title', $product->name)

@section('content')

    <div id="consumer-product">
        <consumer-product
            :product="{{$product}}">
        </consumer-product>
    </div>

@endsection
