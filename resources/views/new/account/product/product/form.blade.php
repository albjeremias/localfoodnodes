{{-- Name --}}
<div class="col-md-10">
    <div class="form-group">
        @include('new.components.forms.input', [
            'label'       => trans('admin/product.product_name'),
            'name'        => 'name',
            'type'        => 'text',
            'class'       => 'form-control',
            'placeholder' => trans('admin/product.product_name_placeholder'),
        ])
    </div>

    {{-- Info --}}
    <div class="form-group">
        @include('new.components.forms.textarea', [
            'label' => trans('admin/product.product_description'),
            'name'  => 'info',
            'class' => 'form-control wysiwyg',
            'rows'  => 5,
            'placeholder' => trans('admin/product.product_description_placeholder'),
            'old'   => $product->info or '',
        ])
    </div>

    {{-- Price --}}
    <div class="form-group">
        <div class="{{ $product->variants()->count() > 0 ? 'disabled' : '' }}">
            @include('new.components.forms.input', [
                'label'       => trans('admin/product.enter_price_one_product'),
                'name'        => 'price',
                'type'        => 'number',
                'class'       => 'form-control',
                'placeholder' => 'Price',
                'min'         => 0
            ])
        </div>
        @if ($product->variants()->count() > 0)
            <div class="form-text">
                {{ trans('admin/product.price_on_variants') }}
            </div>
        @endif
    </div>

    {{-- Price Unit --}}
    <div class="form-group" id="price-unit">
        @include('new.components.forms.dropdown', [
            'label'       => trans('admin/product.price_per'),
            'name'        => 'price_unit',
            'class'       => 'bb-38 form-control',
            'options'     => UnitsHelper::getPriceUnits(),
            'value'       => true,
            'val_key'     => true,
        ])
    </div>

    {{-- Package Amount --}}
    <div class="form-group" id="package-amount">
        @include('new.components.forms.input', [
            'label'       => trans('admin/product.estimate_package_amount'),
            'name'        => 'package_amount',
            'type'        => 'text',
            'class'       => 'form-control',
            'placeholder' => trans('admin/product.estimate_package_amount'),
        ])

        {{--<span class="input-group-addon" id="package-amount-unit"></span>--}}

        <script>
            jQuery(document).ready(function () {
                var packageAmount = function (val) {
                    if (val !== 'product') {
                        $('#package-amount').show();
                        $('#package-amount-unit').text(val);
                    } else {
                        $('#package-amount').hide();
                    }
                };

                $('#price-unit select').on('change', function (event) {
                    packageAmount($(this).val());
                });

                packageAmount($('#price-unit select').val());
            });
        </script>
    </div>

    {{-- Tags --}}
    <div class="form-group">
        <label class="form-control-label">
            {{ trans('admin/product.select_tags') }}
        </label>

        <div class="tags">
            @foreach ($tags as $key => $tag)
                <div class="tag d-inline">
                    <input class="d-none" id="label-{{ $key }}" type="checkbox" name="tags[]"
                           value="{{ $key }}" {{ $product->tag($key) ? 'checked' : '' }}>
                    <label class="tag-label badge badge-light" for="label-{{ $key }}">{{ ucfirst($tag) }}</label>
                </div>
            @endforeach
        </div>
    </div>


    {{-- Images --}}
    <div class="my-4">
        @include('new.components.upload.images', [
            'images' => $product->images(),
            'deleteUrl' => '/account/image/{imageId}/delete',
            'limit' => 4,
        ])
    </div>

    {{-- Payment Info --}}
    <div class="form-group">
        @include('new.components.forms.textarea', [
            'label'       => trans('admin/product.product_payment_info'),
            'name'        => 'payment_info',
            'class'       => 'form-control bb-38',
            'rows'        => 3,
            'placeholder' => trans('admin/product.product_payment_info_placeholder'),
        ])
    </div>

    {{-- Public --}}
    <div class="form-group">
        @include('new.components.forms.checkbox', [
            'name'   => 'is_hidden',
            'text'   => trans('admin/product.hide_from_store'),
            'checked' => $product->is_hidden == 1 ? true : false
        ])
    </div>

    {{-- Payment Deadline --}}
    <div class="form-group">
        @include('new.components.forms.input', [
        'label'       => trans('admin/product.booking_deadline'),
        'name'        => 'deadline',
        'type'        => 'number',
        'class'       => 'form-control',
        'append'      => trans('admin/product.days'),
        'placeholder' => '0',
        'min'         => 0
    ])
    </div>

    <button type="submit" class="btn btn-secondary mt-3 float-right">{{ trans('admin/product.save_product') }}</button>
</div>

{{-- Right Section --}}
<div class="col-md-6">
    @include('new.account.product.product.how-does-it-work')
</div>

