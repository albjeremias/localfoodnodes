@php
    $items = [];
@endphp

@foreach($dates as $date)
    @php
        $deliveryLink = $product->deliveryLink($place->id, $date, true);
        $item = array(
            [
                'tr'       => __('Date'),
                'name'     => '',
                'value'    => $date,
                'type'     => 'text',
                'class'    => 'nb font-weight-bold no-bg text-center',
                'disabled' => true,
                'td_class' => 'w-15',
            ],
            [
                'tr'       => __('Active'),
                'name'     => 'dates[' . $place->id . '][' . $date . '][active]',
                'checked'  => $deliveryLink->active,
                'type'     => 'checkbox',
                'tr_class' => 'text-center'
            ],
            [
                'tr'    => __('Stock'),
                'name'  => 'dates[' . $place->id . '][' . $date . '][stock]',
                'value' => $deliveryLink->stock ?? $product->isInStock($place->id, new DateTime($date)),
                'type'  => 'number',
                'td_class' => 'w-15'
            ],
            [
                'tr'    => __('Price'),
                'name'  => 'dates[' . $place->id . '][' . $date . '][price]',
                'value' => $deliveryLink->price ?? $product->price,
                'type'  => 'number',
                'class' => 'input-stock-fields',
                'td_class' => 'w-15'
            ],
            [
                'tr'    => __('Deadline'),
                'name'  => 'dates[' . $place->id . '][' . $date . '][deadline]',
                'value' => $deliveryLink->deadline ?? $product->deadline,
                'type'  => 'number',
                'td_class' => 'w-15'
            ]
        );
        $index = $loop->index;
        array_push($items, $item);
    @endphp
@endforeach

@include('new.components.tables.form', ['items' => $items ])