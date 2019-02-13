<h5>{{ __('Deliveries') }}</h5>

@if ($node->id)
    <div class="alert alert-danger">
        <i class="fa fa-warning"></i> {{ __(' If you change weekday, interval or start date all products on the node will disappear since their selected delivery date doesn\'t match any longer. ') }}
    </div>
@endif

{{-- Occurrence --}}
<div class="form-group lfn-checkbox">

    <section>
        <div class="checkboxTwo">
            <input type="checkbox" value="1" id="checkboxTwoInput" name="" />
            <label for="checkboxTwoInput"></label>
        </div>
    </section>

    <label class="form-check-label ml-4">
        <input class="form-check-input" name="occurs_once" type="hidden" value="0" />
        <input class="form-check-input" name="occurs_once" type="checkbox" value="1" {{ $node->is_hidden == 1 ? 'checked' : '' }} />
        {{ trans('admin/node.occurs_once') }}
    </label>
</div>

{{-- Recurring--}}
<div id="recurring">
    <div class="form-group">
        <label for="delivery_interval">
            {{ __('Delivery interval') }}
        </label>

        <select name="delivery_interval" id="delivery_interval" class="form-control">
            <option value="">{{ __('Select interval') }}</option>
            @foreach ($node->intervals as $key => $interval)
                <option value="{{ $interval }}" {{ $node->delivery_interval === $interval ? ' selected' : '' }}>{{ trans('admin/node.' . $key) }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- One time --}}
<div id="occurs-once">
    EN GÅNG
</div>