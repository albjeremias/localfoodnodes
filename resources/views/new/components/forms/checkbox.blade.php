{{--
    -Form Checkbox Component-

    *name           | string
    *text           | string
    *checked        | boolean
    container_class | string

    *Required
--}}

<div id="checkbox-container-{{ $name }}" class="form-check {{ isset($container_class) ? $container_class : '' }}">
    <input name="{{ $name }}" class="form-check-input" type="checkbox" value="{{ $value ?? '1' }}" {{ $checked ? 'checked' : '' }} id="checkbox-{{ $name }}">
    <label class="form-check-label" for="defaultCheck1">
        {{ $text }}
    </label>
</div>