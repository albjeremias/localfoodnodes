{{--
    -Form Textarea Component-

    *label       | string
    *name        | string
    *class       | string
    *rows        | integer
    old          | string
    placeholder  | string

    *Required
--}}

<label class="{{ $errors->has($name) ? 'red-c' : '' }}" for="form-textarea-{{ $name }}">{{ $label }}</label>

<textarea name="{{ $name }}"
          class="{{ $class }}"

          @if(isset($placeholder))
            placeholder="{{ $placeholder }}"
          @endif

          id="form-textarea-{{ $name }}"
          rows="{{ $rows }}">{{ $old or '' }}
</textarea>

