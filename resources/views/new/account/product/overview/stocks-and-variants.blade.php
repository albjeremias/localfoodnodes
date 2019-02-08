<div class="col-16">
    <div class="white-box">
        <h4 class="rc d-inline-block">{{ __('Stock and variants') }}</h4>
        <a class="btn btn-secondary float-right" href="{{ route('account_product_stock_and_variants', ['producerId' => $producer->id, 'productid' => $product->id]) }}">Edit</a>

        @php
            $items = array(
                'Stock'     => $product->stock_quantity ?? '-',
                'Reccuring' => $product->stock_type === 'recurring' ? 'Yes' : 'No',
                'CSA'       => $product->productionType === 'csa' ? 'Yes' : 'No',
                'Variants'  => $product->variantCount() > 0 ? $product->variantCount() : 'None',
            );
        @endphp

        @include('new.components.simple-table', [
            'items'         => $items,
            'table_classes' => 'mt-3',
            'bold'          => true
        ])
    </div>
</div>