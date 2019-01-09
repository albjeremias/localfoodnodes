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
                'class'    => 'nb font-weight-bold no-bg text-center',
                'disabled' => true,
                'td_class' => 'w-15',
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
                'type'     => 'checkbox',
                'tr_class' => 'text-center'

            ],
            [
                'tr'    => trans('admin/product.stock'),
                'name'  => 'stock-' . $place->id . '-' . $loop->index,
                'value' => $product->isInStock($place->id, new DateTime($date)),
                'type'  => 'text',
                'td_class' => 'w-15'
            ],
            [
                'tr'    => trans('admin/product.price'),
                'name'  => 'price-' . $place->id . '-' . $loop->index,
                'value' => $product->price,
                'type'  => 'text',
                'class' => 'input-stock-fields',
                'td_class' => 'w-15'
            ],
            [
                'tr'    => trans('admin/product.deadline'),
                'name'  => 'deadline-' . $place->id . '-' . $loop->index,
                'value' => $product->deadline,
                'type'  => 'text',
                'td_class' => 'w-15'
            ]
        );
        $index = $loop->index;
        array_push($items, $item);
    @endphp
@endforeach

@include('new.components.tables.form', ['items' => $items ])