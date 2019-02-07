{{-- Name --}}
<div class="col-md-10">
    <div class="form-group">
        @include('new.components.forms.input', [
            'label'       => __('Product name'),
            'name'        => 'name',
            'type'        => 'text',
            'class'       => 'form-control',
            'placeholder' => __('Product name'),
            'm_value' => $product->name,
        ])
    </div>

    {{-- Info --}}
    <div class="form-group">
        @include('new.components.forms.textarea', [
            'label' => __('Product description'),
            'name'  => 'info',
            'class' => 'form-control wysiwyg',
            'rows'  => 5,
            'placeholder' => __('Product description'),
            'old'   => $product->info,
        ])
    </div>

    {{-- Price --}}
    <div class="form-group">
        <div class="{{ $product->variants()->count() > 0 ? 'disabled' : '' }}">
            @include('new.components.forms.input', [
                'label'       => __('Enter price for one product'),
                'name'        => 'price',
                'type'        => 'number',
                'class'       => 'form-control',
                'placeholder' => 'Price',
                'min'         => 0,
                'm_value' => $product->price,
            ])
        </div>
        @if ($product->variants()->count() > 0)
            <div class="form-text">
                {{ __('Variant price') }}
            </div>
        @endif
    </div>

    {{-- Price Unit --}}
    <div class="form-group" id="price-unit">
        @include('new.components.forms.dropdown', [
            'label'       => __('Price per'),
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
            'label'       => __('Estimate package amount'),
            'name'        => 'package_amount',
            'type'        => 'text',
            'class'       => 'form-control',
            'placeholder' => __('Estimate package amount'),
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
            {{ __('Select tags') }}
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
            'entityType' => 'product',
            'entityId' => $product->id ?: null,
            'images' => $product->images(),
            'limit' => 4,
        ])
    </div>

    {{-- Payment Info --}}
    <div class="form-group">
        @include('new.components.forms.textarea', [
            'label'       => __('Product payment and pickup info'),
            'name'        => 'payment_info',
            'class'       => 'form-control bb-38',
            'rows'        => 3,
            'placeholder' => __('Product specific information about payment and pickup'),
        ])
    </div>

    {{-- Public --}}
    <div class="form-group">
        <div class="form-check mt-4 custom-control custom-checkbox">
            <input name="is_hidden" class="custom-control-input" type="checkbox" id="checkbox-is-hidden" {{ $product->is_hidden ? 'checked' : '' }}>
            <label class="custom-control-label" for="checkbox-is-hidden">
                {{ __('Hide product from store') }}
            </label>
        </div>

    {{-- Detached --}}
        <div class="form-check custom-control custom-checkbox">
            <input name="detached" class="custom-control-input" type="checkbox" value="" id="checkbox-detached">
            <label class="custom-control-label" for="checkbox-detached">
                {{ __('Detach product') }}
                @include('new.components.info', [
                    'text' => __('By using the detached feature you make it possible for costumers to order this product without it connected to specific pick up-spot or date. Delivery is done in other manual ways of suitable choice.'),
                    'placement' => 'right'
                ])
            </label>
        </div>
    </div>

    {{-- Payment Deadline --}}
    <div class="form-group">
        @include('new.components.forms.input', [
        'label'       => __('Booking deadline'),
        'name'        => 'deadline',
        'type'        => 'number',
        'class'       => 'form-control',
        'append'      => __('days'),
        'placeholder' => '0',
        'min'         => 0
    ])
    </div>

    <button type="submit" class="btn btn-secondary mt-3 float-right">{{ _('Save product') }}</button>
</div>

{{-- Right Section --}}
<div class="col-md-6">
    @include('new.account.product.how-does-it-work')
</div>

