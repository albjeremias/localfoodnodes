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
        <div class="my-products-background"></div>
        <div class="my-products-background-overlay"></div>
        <div class="container nm">
            <!-- PRODUCTS -->
            <section class="py-5">
                @if ($products->count() > 0)
                    <div class="container">
                        <div class="row">
                            <div class="col-md-16">
                                    <h2 class="h1 wc mb-0 text-shadow">My products</h2>

                                    <ul class="list-inline mt-4 mb-3 wc">
                                        <li class="list-inline-item mr-4">
                                            <a href="" class="btn btn-primary">Create new product</a>
                                        </li>
                                    </ul>
                            </div>
                            <div class="col-md-8">
                                <div class="white-box little-min">
                                    <h4>Dates</h4>

                                        @include('new.components.forms.dropdown', [
                                            'name' => 'node',
                                            'value' => true,
                                            'label' => 'Select location',
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
                                    <h4>Product list</h4>
                                    <small class="pt-3">Till utlämningen "<strong>Nodens namn</strong>" "<strong>datum</strong>" har "<strong>gårdens namn</strong>" följande produkter till salu.</small>

                                    @include('new.components.carousels.products-slick', [
                                        'products' => [0 => ['name' => 'Test-1'], 1 => ['name' => 'Test-2']]
                                        ])

                                    <input type="text" class="form-control form-control-sm input-buttom-r w-75" readonly value="https://lfn.org/bla">
                                    <a href="#" class="bottom-link text-uppercase rc">Copy link</a>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-4">
                        @foreach ($products->sortBy('name') as $product)
                                <div class="col-16 col-lg-8 col-xl-5 mb-3">
                                    @php
                                        $tag = trans('public/tags.');
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" />
    <script>

        $(document).ready(function(){
            $('.slick-container').slick({
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 5,
                slidesToScroll: 5,
            });
        });
    </script>
@endsection

