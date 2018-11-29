<div class="white-box">
    <h5>Stock and variants</h5>
    <a href="#">Edit</a>
    <ul>
        <li>: {{ $product->getProductionQuantity() }}</li>
        <li>: {{  }}</li>
        <li>CSA: {{ $product->productionType === 'csa' ? 'Yes' : 'No' }}</li>
        <li>Variants: {{ $product->variantCount() > 0 ? $product->variantCount() : 'None' }}</li>
    </ul>


    @php
        $items = array(
            'Stock'        => $product->getProductionQuantity(),
            'Reccuring' => $product->productionType === 'weekly' ? 'Yes' : 'No',
            'CSA' => $product->getPriceWithUnit(),
            'Tax'   => $product->vat ? $product->vat : '0%',
            'Unit' => $product->price_unit,
            'Tags' => $tags_html,
            'Images' => count($product->images()),
            'Payment info' => substr($product->payment_info, 0, 50) . '...',
            'Booking deadline' => $product->deadline . ' days',
            'Visibility' => $product->is_hidden ? 'Hidden' : 'Shown',
            'In app comments' => '<span class="font-italic">Not yet available</span></li>'
        );
    @endphp

    @include('new.components.simple-table', [
        'items'         => $items,
        'table_classes' => ''
    ])
</div>