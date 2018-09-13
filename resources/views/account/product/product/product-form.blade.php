<div class="row">
    <div class="col-12 col-xl-8">
        <div class="card">
            <div class="card-header">
                {{ trans('admin/product.product') }}
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-control-label" for="name">
                        {{ trans('admin/product.product_name') }}
                        @include('account.field-error', ['field' => 'name'])
                    </label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="{{ trans('admin/product.product_name_placeholder') }}" value="{{ $product->name or '' }}">
                </div>

                <div class="form-group">
                    <label class="form-control-label" for="info">
                        {{ trans('admin/product.product_description') }}
                        @include('account.field-error', ['field' => 'info'])
                    </label>
                    <textarea class="form-control wysiwyg" id="info" name="info" rows="5" placeholder="{{ trans('admin/product.product_description_placeholder') }}">{{ $product->info or '' }}</textarea>
                </div>

                <div class="form-group">
                    <div class="{{ $product->variants()->count() > 0 ? 'disabled' : '' }}">
                        <label class="form-control-label" for="price">
                            {{ trans('admin/product.enter_price_one_product') }}
                            @include('account.field-error', ['field' => 'price'])
                        </label>
                        <input type="number" step="0.01" min="0" name="price" class="form-control" id="price" placeholder="{{ trans('admin/product.price') }}" value="{{ $product->price or '' }}">
                    </div>
                    @if ($product->variants()->count() > 0)
                        <div class="form-text">
                            {{ trans('admin/product.price_on_variants') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-control-label" for="price">
                        {{ trans('admin/product.enter_vat') }} (%)
                        @include('account.field-error', ['field' => 'vat'])
                    </label>
                    <input type="number" min="0" name="vat" class="form-control" id="vat" placeholder="{{ trans('admin/product.vat_placeholder') }}" value="{{ $product->vat or '' }}">
                </div>

                <div class="form-group" id="price-unit">
                    <label class="form-control-label" for="price">
                        {{ trans('admin/product.price_per') }}
                        @include('account.field-error', ['field' => 'price_unit'])
                    </label>
                    <select class="form-control" name="price_unit">
                        @foreach (UnitsHelper::getPriceUnits() as $key => $label)
                            <option value="{{ $key }}" {{ $product->price_unit === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="package-amount">
                    <label class="form-control-label" for="package_amount">
                        {{ trans('admin/product.estimate_package_amount') }}
                        @include('account.field-error', ['field' => 'package_amount'])
                    </label>
                    <div class="input-group">
                        <input type="text" name="package_amount" class="form-control" id="price" placeholder="{{ trans('admin/product.estimate_package_amount') }}" value="{{ $product->package_amount or '' }}">
                        <span class="input-group-addon" id="package-amount-unit"></span>
                    </div>
                    <div class="form-text text-muted">
                        {{ trans('admin/product.package_amount_info') }}
                    </div>
                </div>

                <script>
                    jQuery(document).ready(function() {
                        var packageAmount = function(val) {
                            if (val !== 'product') {
                                $('#package-amount').show();
                                $('#package-amount-unit').text(val);
                            } else {
                                $('#package-amount').hide();
                            }
                        };

                        $('#price-unit select').on('change', function(event) {
                            packageAmount($(this).val());
                        });

                        packageAmount($('#price-unit select').val());
                    });
                </script>

                <div class="form-group">
                    <label class="form-control-label">
                        {{ trans('admin/product.select_tags') }}
                    </label>
                    <div class="tags">
                        @foreach ($tags as $key => $tag)
                            <div class="tag">
                                <input id="label-{{ $key }}" type="checkbox" name="tags[]" value="{{ $key }}" {{ $product->tag($key) ? 'checked' : '' }}>
                                <label for="label-{{ $key }}">{{ ucfirst($tag) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <!-- Images -->
        @include('account.image-card', [
            'images' => $product->images(),
            'deleteUrl' => '/account/image/{imageId}/delete',
            'limit' => 4,
        ])

        @include('account.product.product.other-options')
    </div>

    <div class="col-12 col-xl-4">
        @include('account.product.product.how-does-it-work')
    </div>
</div>
