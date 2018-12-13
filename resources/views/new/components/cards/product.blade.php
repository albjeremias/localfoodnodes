@php
    $product_img = false;
    if ($product->images()->count() > 0) :
        $images = $product->images();
        $product_img = $images[0]->url('small');
    endif;

    $product_tag = false;
    if ($product->tags()->count() > 0) :
        $tags = $product->tags();
        $product_tag = $tags[0]->tag;
    endif;

    if (isset($node)) :
        $stock = false;
        $stock = $product->isInStock($node->id);
    endif;
@endphp

<div class="product">
    <div class="product__img-container image {{ $product_img ? '' : 'bg-img-basket' }}" style="background-image: url('{{ $product_img ? $product_img : '' }}')">
        <span class="product__img-container__quantity">{{ isset($stock) ? $stock : '' }} KVAR</span>
        {{--<span class="product-items-quantity badge badge-warning">SLUT</span>--}}

        <i class="product__img-container__share" aria-hidden="true"></i>

        @if($product_tag)
            <small class="product__img-container__tag">{{ trans('public/tags.' . $product_tag) }}</small>
        @endif
    </div>

    <div class="product-container px-3 py-1">

        <a href=""></a><h4 class="h10">{{ $product->name }}</h4>

        <p>Kollinge torpargård</p>

        <i class="fa fa-map-marker" aria-hidden="true"></i>
        <span class="ml-2">2 km</span>
        <hr>

        @if(isset($admin))
            <a href="/account/producer/{{ $producer->id }}/product/{{ $product->id }}">Editera</a>
        @endif
    </div>
</div>
