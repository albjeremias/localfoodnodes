    @php
        $form_table = array(
            [
                'name'    => 'has_stock',
                'text'    => __('Stock'),
                'checked' => $product->has_stock,
                'type'    => 'checkbox',
            ],
            [
                'name'     => 'stock_quantity',
                'type'     => 'number',
                'text'     => __('Quantity'),
                'value'    => $product->stock_quantity,
                'disabled' => !$product->has_stock,
                'class'    => 'w-50'
            ],
            [
                'name'     => 'recurring',
                'text'     => __('Recurring'),
                'checked'  => $product->stock_type === 'recurring',
                'disabled' => !$product->has_stock,
                'type'     => 'checkbox'
            ],
            [
                'name'     => 'csa',
                'text'     => __('CSA'),
                'checked'  => false,
                'disabled' => !$product->has_stock,
                'type'     => 'checkbox'
            ]
        );
    @endphp

    @include('new.components.tables.simple-form', ['items' => $form_table])

<script>
    $(document).ready(function () {
        $('#checkbox-stock').change(function () {
            $('#form-input-amount').prop('disabled', function(i, v) { return !v; });
            $('#checkbox-recurring').prop('disabled', function(i, v) { return !v; });
            $('#checkbox-csa').prop('disabled', function(i, v) { return !v; });
        });
    });
</script>