@php
    $form_table = array(
        [
            'name'    => 'variants',
            'text'    => trans('admin/product.use_variants'),
            'checked' => count($product->productVariants()) > 0 ? true : false,
            'type'    => 'checkbox',
        ],
        [
            'name'     => 'shared-stock',
            'text'     => trans('admin/product.shared_variants_stock'),
            'checked'  => false,
            'disabled' => count($product->productVariants()) < 0 ? true : false,
            'type'     => 'checkbox'
        ],
        [
            'name'     => 'product_content_specified',
            'text'     => trans('admin/product.product_content_specified_in'),
            'options'  => UnitsHelper::getVariantUnits(),
            'value'    => true,
            'val_key'  => true,
            'disabled' => count($product->productVariants()) < 0 ? true : false,
            'type'     => 'dropdown'
        ]
    );
@endphp

@include('new.components.tables.simple-form', ['items' => $form_table])