{{--
    -Form Checkbox Component-

    *name           | string
    *checked        | boolean

    *Required
--}}

<div id="checkbox-container-{{ $name }}" class="form-check">
    <input
            name="{{ $name }}"
            {{ $disabled ? 'disabled' : '' }}
            class="form-check-input"
            type="checkbox"
            value="1" {{ $checked ? 'checked' : '' }}
            id="checkbox-{{ $name }}">
</div>