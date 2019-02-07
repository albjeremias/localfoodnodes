{{--
    -Form Radiobutton Component-

    *name           | string
    *checked        | boolean

    *Required
--}}

<div id="checkbox-container-{{ $name }}" class="">
    <input
            name="{{ $name }}"
            {{ $disabled ? 'disabled' : '' }}
            class="d-block mx-auto"
            type="radio"
            value="{{ $value ?? '1' }}"
            {{ $checked ? 'checked' : '' }}
            id="checkbox-{{ $name }}">
</div>