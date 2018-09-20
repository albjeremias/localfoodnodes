{{--
    -Form Checkbox Component-

    *name        | string
    *text         | string
    *checked      | boolean

    *Required
--}}

<label class="form-check-label ml-4">
    <input class="form-check-input" name="{{ $name }}" type="checkbox" value="1" {{ $checked ? 'checked' : '' }} />
    {{ $text }}
</label>