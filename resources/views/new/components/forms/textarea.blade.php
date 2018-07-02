{{--
    -Form Textarea Component-

    *label       | string
    *name        | string
    *class       | string
    *rows        | integer
    *old         | string

    *Required
--}}

<label for="form-textarea-{{ $name }}">{{ $label }}</label>

<textarea name="{{ $name }}"
          class="{{ $class }}"
          id="form-textarea-{{ $name }}"
          rows="{{ $rows }}">
          {{ $old or '' }}
</textarea>