<div class="card">
    <div class="card-header">
        {{ __('Other options') }}
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="payment-info">
                {{ __('Product payment and pickup info') }}
            </label>
            <textarea class="form-control" id="payment-info" name="payment_info" rows="3" placeholder="{{ __('Product specific information about payment and pickup') }}">{{ $product->payment_info }}</textarea>
        </div>

        <div class="form-check">
            <fieldset class="form-group">
                <legend class="col-form-legend">{{ __('Visibility') }}</legend>
                <label class="form-check-label">
                    <input class="form-check-input" name="is_hidden" type="hidden" value="0" />
                    <input class="form-check-input" name="is_hidden" type="checkbox" value="1" {{ $product->is_hidden == 1 ? 'checked' : '' }} />
                    {{ __('Hide from store') }}
                </label>
            </fieldset>
        </div>
        <div class="row">
            <div class="form-group col-12 col-lg-6">
                <label class="control-label" for="deadline">{{ __('Booking deadline') }}</label>
                <div class="input-group">
                    <input type="number" min="0" name="deadline" class="form-control" id="deadline" placeholder="0" value="{{ $product->deadline or 0 }}">
                    <div class="input-group-append">
                        <span class="input-group-text">{{ __('days') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
