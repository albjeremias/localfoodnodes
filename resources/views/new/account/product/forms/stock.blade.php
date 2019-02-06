
    @php
        $form_table = array(
            [
                'name'    => 'stock',
                'text'    => __('Stock'),
                'checked' => $product->productions()->count() > 0 ? true : false,
                'type'    => 'checkbox',
            ],
            [
                'name'     => 'amount',
                'type'     => 'number',
                'text'     => __('Quantity'),
                'disabled' => $product->productions()->count() < 0 ? true : false,
                'class'    => 'w-50'
            ],
            [
                'name'     => 'recurring',
                'text'     => __('Recurring'),
                'checked'  => false,
                'disabled' => $product->productions()->count() < 0 ? true : false,
                'type'     => 'checkbox'
            ],
            [
                'name'     => 'csa',
                'text'     => __('CSA'),
                'checked'  => false,
                'disabled' => $product->productions()->count() < 0 ? true : false,
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