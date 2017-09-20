<div class="card-block">
    <div class="row">
        @foreach ($products->sortBy('name') as $product)
            @if ($product->isVisible($node->id) === true)
                <div class="col-6 col-lg-4 card-deck">
                    <a class="card product-card" href="{{ $node->permalink()->url }}{{ $product->permalink()->url }}">
                        @if ($product->images()->count() > 0)
                            <img class="card-image-top" src="{{ $product->images()->first()->url('small') }}">
                        @else
                            <img class="card-image-top" src="/images/product-image-placeholder.jpg">
                        @endif

                        <div class="card-block">
                            <div class="producer-info">
                                <div class="name">{{ $product->producer()->name }}</div>
                            </div>
                            <div class="title">
                                {{ $product->name }}
                            </div>
                            <div class="price">
                                @if ($product->variants()->count() > 0)
                                    {{ trans('public/node.from') }} {{ $product->smallestVariant()->getPriceWithUnit() }}
                                @else
                                    {{ $product->getPriceWithUnit() }}
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <i class="fa fa-map-marker"></i> {{ $product->producer()->getDistance($node) }} {{ trans('public/node.km') }}
                            <div class="tags">
                                @foreach ($product->tags() as $tag)
                                    <div class="badge badge-default">{{ trans('public/tags.' . $tag->tag) }}</div>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
</div>
