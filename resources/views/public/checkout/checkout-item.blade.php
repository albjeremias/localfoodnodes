    <div class="cart-item">
        <div class="row cart-item-inner">
            <div class="col-md-2 hidden-sm-down">
                @if ($cartDateItemLink->getItem()->getProduct() && $cartDateItemLink->getItem()->getProduct()->images()->count() > 0)
                    <img src="{{ $cartDateItemLink->getItem()->getProduct()->images()->first()->url('medium') }}">
                @else
                    <img src="/images/product-image-placeholder.jpg">
                @endif
            </div>

            <div class="col-8 col-md-6">
                <div class="product-variant-name">
                    <h3 class="product-name">{{ $cartDateItemLink->getItem()->getProductName() }}</h3>
                    @if ($cartDateItemLink->getItem()->variant)
                        <div class="variant-name">{{ $cartDateItemLink->getItem()->getVariantName() }}</div>
                    @endif
                </div>
                <div>
                    @if ($cartDateItemLink->getItem()->getProducer())
                        <a href="{{ $cartDateItemLink->getItem()->getProducer()->permalink()->url }}">{{ $cartDateItemLink->getItem()->producer['name'] }}</a>
                    @else
                        {{ $cartDateItemLink->getItem()->producer['name'] }}
                    @endif
                    -
                    @if ($cartDateItemLink->getItem()->getNode())
                        <a href="{{ $cartDateItemLink->getItem()->getNode()->permalink()->url }}">{{ $cartDateItemLink->getItem()->node['name'] }}</a>
                    @else
                        {{ $cartDateItemLink->getItem()->node['name'] }}
                    @endif
                </div>
                @if ($cartDateItemLink->getItem()->message)
                    <p class="text-muted">{{ trans('public/checkout.message') }}: {{ $cartDateItemLink->getItem()->message }}</p>
                @endif
            </div>

            <!-- Desktop only -->
            <div class="col-2 hidden-sm-down text-right">
                <form action="/checkout/item/{{ $cartDateItemLink->id }}/update" method="post">
                    {{ csrf_field() }}
                    <div class="input-group">
                       <input class="form-control quantity-input" name="quantity" value="{{ $cartDateItemLink->quantity }}" placeholder="Qty">
                    </div>
                </form>
                <a href="/checkout/item/{{ $cartDateItemLink->id }}/remove">{{ trans('public/checkout.remove') }}</a>
            </div>

            <div class="col-4 col-md-2 text-right price-unit">
                {!! $cartDateItemLink->getPriceWithUnitHtml() !!}
            </div>

            <!-- Mobile only -->
            <div class="col-4 col-sm-3 col-xs-6 hidden-md-up text-right mt-3">
                <form action="/checkout/item/{{ $cartDateItemLink->id }}/update" method="post">
                    {{ csrf_field() }}
                    <div class="input-group">
                       <input class="form-control quantity-input" name="quantity" value="{{ $cartDateItemLink->quantity }}" placeholder="Qty">
                    </div>
                </form>
                <a href="/checkout/item/{{ $cartDateItemLink->id }}/remove">{{ trans('public/checkout.remove') }}</a>
            </div>
        </div>
    </div>
