@php
    $form_table = array(
        [
            'name'    => 'variants',
            'text'    => __('Use variants'),
            'checked' => count($product->productVariants()) > 0 ? true : false,
            'type'    => 'checkbox',
        ],
        [
            'name'     => 'shared-stock',
            'text'     => __('Shared variant stock'),
            'checked'  => false,
            'disabled' => count($product->productVariants()) < 0 ? true : false,
            'type'     => 'checkbox'
        ],
        [
            'name'     => 'product_content_specified',
            'text'     => __('Content specified in'),
            'options'  => UnitsHelper::getVariantUnits(),
            'value'    => true,
            'val_key'  => true,
            'disabled' => count($product->productVariants()) < 0 ? true : false,
            'type'     => 'dropdown'
        ]
    );
@endphp

@include('new.components.tables.simple-form', ['items' => $form_table])