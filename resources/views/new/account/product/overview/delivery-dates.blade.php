<div class="col-16">
    <div class="white-box">
        <h4 class="d-inline-block rc">Delivery dates</h4>
        <a class="btn btn-secondary float-right" href="{{ '/account/producer/' . $active_producer_id . '/product/' . $product->id . '/deliveries' }}">Edit</a>

        @php
            $farms = [];
            $nodes = [];

            foreach($product->deliveryLinks(null, null, true) as $link) {
                $farms[$product->producerRelationship->name] = 1;
            }

            foreach($product->deliveryLinks(null, null, true) as $link) {
                $nodes[$link->nodeRelationship->name] = 1;
            }
        @endphp

        <h5 class="mt-3">Farm delivery</h5>
        @include('new.components.simple-table', [
            'items'         => $farms,
            'table_classes' => 'mb-4',
            'bold'          => true,
        ])

        <h5>Nodes</h5>
        @include('new.components.simple-table', [
            'items'         => $nodes,
            'table_classes' => 'mb-4',
            'bold'          => true,
        ])

        <h5>Home delivery</h5>
        @include('new.components.simple-table', [
            'items'         => ['<span class="font-italic">Not yet available</span></li>' => ''],
            'table_classes' => 'mb-4',
            'bold'          => false,
        ])

        <h5 class="mt-3">Shipping</h5>
        @include('new.components.simple-table', [
            'items'         => ['<span class="font-italic">Not yet available</span></li>' => ''],
            'table_classes' => 'mt-3',
            'bold'          => false,
        ])

    </div>
</div>