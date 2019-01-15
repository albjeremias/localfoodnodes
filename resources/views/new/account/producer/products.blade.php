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
                        <div class="row">
                            <div class="col-md-8">
                                <div class="white-box little-min">
                                    <h4>Administrate products</h4>

                                        @include('new.components.forms.dropdown', [
                                            'name' => 'node',
                                            'value' => true,
                                            'label' => 'Select thingy',
                                            'class' => 'mb-3',
                                            'selected' => 'test-2',
                                            'options' => ['test-1' => '1', '2' => 'Söderhamn', '3' => 'Blentarp']
                                        ])

                                        @include('new.components.forms.dropdown', [
                                            'name' => 'date',
                                            'value' => false,
                                            'label' => 'Select date',
                                            'options' => ['test-1' => '1992-05-29', 'test-2' => '2019-01-01']
                                        ])

                                    <a href="#" class="bottom-link text-uppercase rc">Add new date</a>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="white-box little-min">
                                    <h4>Product info</h4>
                                    <small class="pt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto consequatur dicta dolorum ea, eaque ipsa itaque.</small>

                                    <div class="row mt-5">
                                        <div class="col-md-6">
                                            <h3 class="m-0">1992-05-29</h3>
                                            <small>Choosen date</small>
                                        </div>

                                        <div class="col-md-4">
                                            <h3 class="m-0">{{ $products->count() }}</h3>
                                            <small>Products</small>
                                        </div>

                                        <div class="col pl-md-5">
                                            <h3 class="m-0 d-inline-block" data-toggle="tooltip" data-placement="bottom" title="Här ska aktiva produkter listas">3</h3>
                                            <small class="d-block">Active products</small>
                                        </div>
                                    </div>
                                    <a href="#" class="bottom-link text-uppercase rc">Product list</a>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-4">
                        @foreach ($products->sortBy('name') as $product)
                                <div class="col-16 col-lg-8 col-xl-5 mb-3">
                                    @php
                                        $tag = trans('public/tags.' . $product->tags()[0]->tag);
                                    @endphp
                                    <card-product-edit
                                        :product="{{ json_encode($product) }}"
                                        :variants="{{ json_encode($product->variants()) }}"
                                        {{--:images="{{ json_encode($product->images()) }}"--}}
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

