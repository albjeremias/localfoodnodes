@extends('new.account.layout',
[
    'nav_title'      => trans('admin/user.nav_title'),
    'sub_nav'        => 'producer',
    'sub_nav_active' => 2,
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')
    <div id="new-vue-app" class="bg-shell">
        <div class="container nm">
            <!-- PRODUCTS -->
            <section class="py-5">
                @if ($products->count() > 0)
                    <div class="container">
                        <div class="row justify-content-center">
                            @foreach ($products->sortBy('name') as $product)
                                <div class="col-16 col-lg-8 col-xl-5 mb-3">
                                    {{--@include('new.components.cards.product-edit')--}}
                                    @php
                                        $tag = trans('public/tags.' . $product->tags()[0]->tag);
                                    @endphp
                                    <card-product-edit
                                        :product="{{ json_encode($product) }}"
                                        :variants="{{ json_encode($product->variants()) }}"
                                        :images="{{ json_encode($product->images()) }}"
                                        :tag="{{ json_encode($tag) }}"
                                        :producer="{{ json_encode($producer) }}"
                                    ></card-product-edit>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection

