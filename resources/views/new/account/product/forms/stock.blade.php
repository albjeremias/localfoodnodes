
    @php
        $form_table = array(
            [
                'name'    => 'stock',
                'text'    => trans('admin/product.stock'),
                'checked' => $product->productions()->count() > 0 ? true : false,
                'type'    => 'checkbox',
            ],
            [
                'name'     => 'amount',
                'type'     => 'number',
                'text'     => trans('admin/product.quantity'),
                'disabled' => $product->productions()->count() < 0 ? true : false,
                'class'    => 'w-50'
            ],
            [
                'name'     => 'recurring',
                'text'     => trans('admin/product.recurring'),
                'checked'  => false,
                'disabled' => $product->productions()->count() < 0 ? true : false,
                'type'     => 'checkbox'
            ],
            [
                'name'     => 'csa',
                'text'     => 'CSA',
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