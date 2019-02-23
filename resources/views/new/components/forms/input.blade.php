{{--
    -Form Input Component-

    *name        | string
    *type        | string
    *class       | string
    label        | string
    placeholder  | string
    info_text    | string
    info_link    | string
    value        | *
    label_cap    | boolean
    min          | integer
    append       | string
    disabled     | boolean

    *Required
--}}

@php
    if($errors->has($name)) :
        $placeholder =  $errors->first($name);
    endif
@endphp

@if(isset($label))
    <label for="form-input-{{ $name }}" class="{{ $errors->has($name) ? 'red-c' : '' }} {{ isset($label_cap) ? 'text-uppercase' : '' }}">{{ $label }}</label>
@endif

@if(isset($info_text))
    <a class="float-right" href="{{ $info_link }}">
        <small>{{ $info_text }}</small>
    </a>
@endif
<div class="input-group">


<input type="{{ $type }}"
       aria-describedby="input-aria-{{ $name }}"
       name="{{ $name }}"
       {{ isset($min) ? 'min='.$min : '' }}
       class="{{ $class }} {{ $errors->has($name) ? 'placeholder-error red-b' : '' }}"
       id="form-input-{{ $name }}"
       value="{{ isset($m_value) ? $m_value : '' }}"
       placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
       {{ isset($disabled) && $disabled ? 'disabled' : '' }}>

@if(isset($append))
    <div class="input-group-append">
        <span class="input-group-text" id="input-aria-{{ $name }}">{{ $append }}</span>
    </div>
@endif
</div>



