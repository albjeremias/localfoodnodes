@extends('new.public.layout',
[
    'sub_nav'        => 'node',
    'nav_active' => 0,
    'sub_nav_active' => 0,
    'node_slug'      => 'bygdens-saluhall-billinge',
]
)

@section('title', $product->name)

@section('content')

    <div class="bg-shell nm" id="products-administration">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div class="col-md-16">
                        <div class="white-box" style="height: 700px; overflow: scroll">
                            <h2 class="text-center">{{ $product->name }}</h2>
                            <img class="my-2 box-shadow-square" style="width: 100%; height: 300px; object-fit: cover;" src="{{ $product->images()[0]->url() }}"/>
                            <p>{!! $product->info !!}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="white-box" style="height: 200px">
                        <h4 class="rc mb-0">{{ $product->producer()->name }}</h4>
                        <small>{{ $product->producer()->email }}</small>
                        <div class="pt-3">{!! $product->producer()->info !!}</div>
                    </div>

                    <div class="white-box" style="max-height: 493px; overflow: hidden;">
                            <div class="d-flex">
                                <a href="/account/producer/{{ $product->producer()->id }}/products" class="rc">
                                    <h4>{{ $product->producer()->name }} {{ __('products') }}</h4>
                                </a>
                            </div>
                            <div class="overflow-scroll h-100">
                                <div class="producer-products-list">
                                    <ul class="list-unstyled node-list mt-2 list-group">
                                        @foreach($product->producer()->products() as $product)
                                            <a class="my-0 py-2 list-group-item-action">
                                                <div class="products-list-image">
                                                    <img class="box-shadow" src="{{ '/images/shutterstock_436974091.jpg' }}">
                                                </div>
                                                <small class="col black-87">{{ $product->name }}</small>
                                            </a>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-md-16">
                    <div class="white-box">

                        <!--Select variant-->
                        <div class="dropdown show dropdown-form d-inline-flex mb-3 w-25 mr-4">

                            <span class="dropdown-toggle w-100 select-location" href="#" role="button" id="select-location" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Variants
                            </span>

                            <div class="dropdown-menu dropdown-form-menu" aria-labelledby="select-location">
                                <a class="dropdown-item" href="#">Nodes</a>
                                <a v-for="" @click="selectedNode = node" class="dropdown-item" href="#"><small>-</small></a>

                                <a class="dropdown-item" href="#">Ad Hocs</a>
                                <a class="dropdown-item" href="#"><small class="rc text-uppercase font-weight-bold">-Add new</small></a>

                                <a class="dropdown-item" href="#">Home deliveries</a>
                                <a class="dropdown-item" href="#"><small class="font-italic">-Not yet available</small></a>
                            </div>
                        </div>

                        {{-- Select utlämningsplats --}}
                        <div class="dropdown show dropdown-form d-inline-flex mt-3 w-25">
                            <span class="dropdown-toggle w-100 select-location" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select pickup spot
                            </span>

                            <div class="dropdown-menu dropdown-form-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#"></a>

                                <a class="dropdown-item" href="#"><small class="rc text-uppercase font-weight-bold">-Add new date</small></a>
                            </div>
                        </div>

                        <div class="delivery-dates-container">
                            <div class="row p-1">
                                @foreach([1,2,3,4,5,6,7,8,9,10,11,12] as $date)
                                    <div class="col-md-4">
                                        <div class="box-shadow-square mb-3 p-2">
                                            <h3 class="text-center rc">29-05-2018</h3>
                                            <h5 class="text-center mt-2">129 kr</h5>
                                            <div class="text-center mt-2">
                                                <div class="d-inline-block mr-4">
                                                    <p class="m-0">3</p>
                                                    <small>Saldo</small>
                                                </div>

                                                <div class="d-inline-block">
                                                    <p class="m-0">1</p>
                                                    <small>Deadline</small>
                                                </div>
                                            </div>

                                            <input type="text" aria-describedby="input-aria-name" name="quantity" class="form-control input-group mt-2" id="form-input-stock" value="" placeholder="Quantity..." autocomplete="off">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Måste skriva i om detached --}}
                        <div class="row">
                            <div class="col-md-8 mt-4">
                                <textarea class="d-inline-block w-100" rows="4" placeholder="Medelande till producent..."></textarea>
                            </div>
                            <div class="col-md-8 d-flex">
                                <div class="m-auto">
                                    <button class="btn btn-primary">Lägg till i varukorg</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" />
@endsection
