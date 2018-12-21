<div id="new-variants-container" class="d-none">
    @php
        $items = [];

        $new_item = array(
            [
                'tr'    => trans('admin/product.image'),
                'name'  => 'new-variant-image',
                'value' => 'https://local-food-nodes.s3.eu-central-1.amazonaws.com/201810161102_img_4010_jpeg_small.jpeg',
                'type'  => 'image',
                'class' => 'rounded-circle',
            ],
            [
                'tr'          => trans('admin/product.name'),
                'name'        => 'new-variant-name',
                'value'       => '',
                'type'        => 'text',
                'class'       => 'w-100',
                'tr_class'    => 'w-35',
                'placeholder' => 'Add new variant...'
            ],
            [
                'tr'       => trans('admin/product.main_variant'),
                'name'     => 'new-variant-main',
                'type'     => 'radio',
                'checked'  => false,
                'disabled' => true,
            ],
            [
                'tr'    => trans('admin/product.amount_per_package'),
                'name'  => 'new-variant-amount',
                'value' => '',
                'type'  => 'number'
            ],
            [
                'tr'    => trans('admin/product.stock'),
                'name'  => 'new-variant-stock',
                'value' => '',
                'type'  => 'number',
                'class' => 'input-stock-fields',
            ],
            [
                'tr'    => trans('admin/product.price'),
                'name'  => 'new-variant-price',
                'value' => '',
                'type'  => 'number'
            ]
        );
        array_push($items, $new_item);
    @endphp

    @include('new.components.tables.form', ['items' => $items ])
</div>

<script>
    $(document).ready(function () {
        var variants_container = $('#new-variants-container');
        var is_variants_checked = $('input[name="variants"]:checked').length > 0;
        var variants_checkbox = $('#checkbox-variants');

        if (is_variants_checked) {
            variants_container.removeClass('d-none');
        } else {
            variants_container.addClass('d-none');
        }

        variants_checkbox.change(function () {
            variants_container.toggleClass('d-none');
        });

        $('#checkbox-shared-stock').change(function () {
            $('.input-stock-fields').prop('disabled', function(i, v) { return !v; });
        });
    });
</script>