<div class="white-box">
    <h5>Stock and variants</h5>
    <a href="#">Edit</a>
    <ul>
        <li>Stock: {{ $product->getProductionQuantity() }}</li>
        <li>Reccuring: {{ $product->productionType === 'weekly' ? 'Yes' : 'No' }}</li>
        <li>CSA: {{ $product->productionType === 'csa' ? 'Yes' : 'No' }}</li>
        <li>Variants: {{ $product->variantCount() > 0 ? $product->variantCount() : 'None' }}</li>
    </ul>
</div>