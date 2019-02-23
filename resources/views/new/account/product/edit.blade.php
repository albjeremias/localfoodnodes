@extends('new.account.layout',
[
    'sub_nav' => 'producer',
    'nav_active' => 1,
    'sub_nav_active' => 1,
])

@section('title', $product->name)

@section('content')
    <div class="container nm py-5">
        <h2>{{ $product->name ?? __('Product') }}</h2>
        <form action="{{ route('account_product_update', ['producerId' => $producer->id, 'productId' => $product->id]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="type" value="basic"/>
            <div class="row">
                @include('new.account.product.forms.basic-info')
            </div>

            <div class="row">
                <a href="" type="submit" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-secondary ml-auto">{{ _('Save product') }}</button>
            </div>
        </form>
    </div>
@endsection
