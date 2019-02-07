@php
    $form_table = array(
        [
            'name'    => 'variants',
            'text'    => __('Use variants'),
            'checked' => count($product->productVariants()) > 0 ? true : false,
            'type'    => 'checkbox',
        ],
        [
            'name'     => 'shared_variant_quantity',
            'text'     => __('Shared variant stock'),
            'checked'  => $product->shared_variant_quantity,
            'disabled' => count($product->productVariants()) < 0 ? true : false,
            'type'     => 'checkbox'
        ],
        [
            'name'     => 'package_unit',
            'text'     => __('Content specified in'),
            'options'  => UnitsHelper::getVariantUnits(),
            'value'    => $product->package_unit,
            'val_key'  => true,
            'disabled' => count($product->productVariants()) < 0 ? true : false,
            'type'     => 'dropdown'
        ]
    );
@endphp

@include('new.components.tables.simple-form', ['items' => $form_table])