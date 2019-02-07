<div id="new-variants-container" class="d-none">
    @php
        $items = [];

        $new_item = array(
            [
                'tr'    => __('Image'),
                'name'  => 'image',
                'value' => 'https://local-food-nodes.s3.eu-central-1.amazonaws.com/201810161102_img_4010_jpeg_small.jpeg',
                'type'  => 'image',
                'class' => 'rounded-circle',
            ],
            [
                'tr'          => __('Name'),
                'name'        => 'variants[new][name]',
                'value'       => '',
                'type'        => 'text',
                'class'       => 'w-100',
                'tr_class'    => 'w-35',
                'placeholder' => 'Add new variant...'
            ],
            [
                'tr'       => __('Main variant'),
                'name'     => 'main_variant',
                'type'     => 'radio',
                'checked'  => false,
                'disabled' => true,
            ],
            [
                'tr'    => __('Amount per package'),
                'name'  => 'variants[new][package_amount]',
                'value' => $product->package_amount,
                'type'  => 'number'
            ],
            [
                'tr'    => __('Stock'),
                'name'  => 'variants[new][quantity]',
                'value' => $product->quantity,
                'type'  => 'number',
                'class' => 'input-stock-fields',
            ],
            [
                'tr'    => __('Price'),
                'name'  => 'variants[new][price]',
                'value' => $product->price,
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