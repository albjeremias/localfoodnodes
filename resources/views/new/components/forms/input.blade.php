{{--
    -Form Input Component-

    *label       | string
    *name        | string
    *type        | string
    *class       | string
    *placeholder | string

    *Required
--}}

<label for="form-input-{{ $name }}" class="{{ $errors->has($name) ? 'red-c' : '' }}">{{ $label }}</label>

<input type="{{ $type }}"
       name="{{ $name }}"
       class="{{ $class }} {{ $errors->has($name) ? 'placeholder-error red-b' : '' }}"
       id="form-input-{{ $name }}"
       placeholder="{{ $errors->has($name) ? $errors->first($name) : $placeholder }}">



