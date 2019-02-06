@extends('new.account.layout',
[
    'nav_title'   => trans('admin/user.nav_title'),
    'sub_nav' => 'producer',
    'nav_active' => 1,
    'sub_nav_active' => 1,
])

@section('title', trans('public/register.title_producer'))

@section('content')

    <div class="nms">

        <div class="container py-5">
            <h2>{{ __('Product') }}</h2>

            <form action="{{ route('account_product_insert', ['producerId' => $producer->id ]) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                <input type="hidden" name="type" value="basic"/>
                <div class="row">
                    @include('new.account.product.forms.basic-info')
                </div>
            </form>
        </div>
    </div>
@endsection
