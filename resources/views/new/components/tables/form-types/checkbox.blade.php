{{--
    -Form Checkbox Component-

    *name           | string
    *checked        | boolean

    *Required
--}}

<div id="checkbox-container-{{ $name }}">
    <input
            name="{{ $name }}"
            {{ $disabled ? 'disabled' : '' }}
            class="d-block mx-auto"
            type="checkbox"
            value="{{ $value ?? '1' }}" {{ $checked ? 'checked' : '' }}
            id="checkbox-{{ $name }}">
</div>