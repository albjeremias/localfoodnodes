@extends('new.account.layout',
[
    'nav_title'      => trans('admin/user.nav_title'),
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')
    <div class="nms bg-shell">

        @include('new.components.progress',
        [
        'active' => 1,
        'steps'  =>
            [
                trans('admin/producer.product'),
                trans('admin/producer.production'),
                trans('admin/producer.delivery_dates'),
                trans('admin/producer.variants')
            ]
        ])

        <div class="container py-5">
            <h2>{{ trans('admin/product.production') }}</h2>
            <div class="row">
                <div class="col-md-10">
                    <div class="white-box">
                        <div class="text-center">{{ trans('admin/product.production_type_header') }}</div>
                            <ul class="no-bullets">
                                <li>
                                    <b class="d-block">{{ trans('admin/product.recurring_products_weekly') }}</b>
                                    {!! trans('admin/product.recurring_products_info') !!}
                                </li>
                                <li class="mt-3">
                                    <b class="d-block">{{ trans('admin/product.occasional_products') }}</b>
                                    {!! trans('admin/product.occasional_products_info') !!}
                                </li>
                                <li class="mt-3">
                                    <b class="d-block">{{ trans('admin/product.csa_products') }}</b>
                                    {!! trans('admin/product.csa_products_info') !!}
                                </li>
                            </ul>
                    </div>


                    <form action="/account/producer/{{ $producer->id }}/product/{{ $product->id }}/production/update" method="post" enctype="multipart/form-data"
                        {{ csrf_field() }}

                        @include('new.account.product.production.production-form')
                        <button type="submit" name="update" class="btn btn-success">{{ trans('admin/product.save') }}</button>
                    </form>
                </div>
                <div class="col-md-6">
                    @include('new.account.product.product.how-does-it-work')
                </div>
            </div>
        </div>
    </div>
@endsection

