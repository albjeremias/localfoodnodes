<div class="col-16">
    <div class="white-box">
        <h4 class="d-inline-block">Stock and variants</h4>
        <a class="btn btn-secondary float-right" href="#">Edit</a>

        @php
            $items = array(
                'Stock'     => $product->getProductionQuantity(),
                'Reccuring' => $product->productionType === 'weekly' ? 'Yes' : 'No',
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