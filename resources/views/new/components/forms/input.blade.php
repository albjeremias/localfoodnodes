{{--
    -Form Input Component-

    label        | string
    *name        | string
    *type        | string
    *class       | string
    *placeholder | string
    info_text    | string
    info_link    | string
    label_cap    | boolean

    *Required
--}}

@if(isset($label))
    <label for="form-input-{{ $name }}" class="{{ $errors->has($name) ? 'red-c' : '' }} {{ isset($label_cap) ? 'text-uppercase' : '' }}">{{ $label }}</label>
@endif

@if(isset($info_text))
    <a class="float-right" href="{{ $info_link }}">
        <small>{{ $info_text }}</small>
    </a>
@endif

<input type="{{ $type }}"
       name="{{ $name }}"
       class="{{ $class }} {{ $errors->has($name) ? 'placeholder-error red-b' : '' }}"
       id="form-input-{{ $name }}"
       placeholder="{{ $errors->has($name) ? $errors->first($name) : $placeholder }}">



