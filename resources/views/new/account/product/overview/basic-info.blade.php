<div class="col-16">
    <div class="white-box">
        <h4 class="d-inline-block">Basic info</h4>
        <a class="btn btn-secondary float-right" href="{{ '/account/producer/' . $active_producer_id . '/product/' . $product->id . '/edit' }}">Edit</a>

        @php
            $tags_html = '';
        @endphp

        @foreach($product->tags() as $tag)
            @php
                $tags_html .= ucfirst($tag->tag);
                $tags_html .= $loop->index+1 == count($product->tags()) ? '' : ', ';
            @endphp
        @endforeach

        @php
            $items = array(
                'Name'        => $product->name,
                'Description' => substr(strip_tags($product->info), 0, 50) . '...',
                'Price' => $product->getPriceWithUnit(),
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
            'table_classes' => 'mt-3',
            'bold'          => true
        ])
    </div>
</div>