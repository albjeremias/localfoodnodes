@extends('new.account.layout',
[
    'bread_type'   => trans('public/nav.admin'),
    'bread_result' => trans('public/nav.create_product')
])

@section('title', trans('public/register.title_producer'))

@section('content')

    <div class="nms">

        @include('new.components.progress',
        [
        'active' => 0,
        'steps'  =>
            [
                trans('admin/producer.product'),
                trans('admin/producer.production'),
                trans('admin/producer.delivery_dates'),
                trans('admin/producer.variants')
            ]
        ])

        <div class="container py-5">
            <h2>{{ trans('admin/product.product') }}</h2>



            <form action="/account/producer/{{ $producer->id }}/product/insert" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                <input type="hidden" name="type" value="basic"/>
                <div class="row">
                    @include('new.account.product.product.form')
                </div>
            </form>
        </div>
    </div>
@endsection
