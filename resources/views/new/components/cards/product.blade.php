<div class="product">
    <div class="product-img bg-img-basket image">
        <span class="product-items-quantity badge badge-success">20 KVAR</span>
        {{--<span class="product-items-quantity badge badge-warning">SLUT</span>--}}

        <i class="product-items-share fa fa-share icon" aria-hidden="true"></i>
        <span class="product-items-type badge-sm badge-pill badge-danger">Bröd</span>
    </div>

    <div class="product-container px-3 py-1">

        <a href=""></a><h4 class="h10">{{ $product->name }}</h4>

        <p>Kollinge torpargård</p>

        <i class="fa fa-map-marker" aria-hidden="true"></i>
        <span class="ml-2">2 km</span>
        <hr>

    @if(isset($admin))
            <a href="/account/producer/{{ $producer->id }}/product/{{ $product->id }}/edit">Editera</a>
        @endif
    </div>
</div>
