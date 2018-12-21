@php
    $items = [];
@endphp

@foreach($dates as $date)
    @php
        $item = array(
            [
                'tr'       => trans('admin/product.date'),
                'name'     => 'date-' . $place->id . '-' . $loop->index,
                'value'    => $date,
                'type'     => 'text',
                'class'    => 'nb font-weight-bold no-bg',
                'disabled' => true,
            ],
            [
                'tr'       => trans('admin/product.name'),
                'name'     => 'name-' . $place->id . '-' . $loop->index,
                'type'     => 'text',
                'class'    => 'nb no-bg',
                'disabled' => true,
                'value'    => $product->name,
            ],
            [
                'tr'       => trans('admin/product.active'),
                'name'     => 'active-' . $place->id . '-' . $loop->index,
                'checked'  => true,
                'type'     => 'checkbox'
            ],
            [
                'tr'    => trans('admin/product.stock'),
                'name'  => 'stock-' . $place->id . '-' . $loop->index,
                'value' => $product->isInStock($place->id, new DateTime($date)),
                'type'  => 'text'
            ],
            [
                'tr'    => trans('admin/product.price'),
                'name'  => 'price-' . $place->id . '-' . $loop->index,
                'value' => $product->price,
                'type'  => 'text',
                'class' => 'input-stock-fields',
            ],
            [
                'tr'    => trans('admin/product.deadline'),
                'name'  => 'deadline-' . $place->id . '-' . $loop->index,
                'value' => $product->deadline,
                'type'  => 'text'
            ]
        );
        $index = $loop->index;
        array_push($items, $item);
    @endphp
@endforeach

{{-- Empty row for adding a new variant --}}
@php
    // $new_item = array();
    // array_push($items, $new_item);
@endphp

@include('new.components.tables.form', ['items' => $items ])