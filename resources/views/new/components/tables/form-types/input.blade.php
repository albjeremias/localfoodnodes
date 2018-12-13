{{--
    -Form Table Input Component-

    *name        | string
    *type        | string
    placeholder  | string
    min          | integer
    append       | string
    class        | string
    disabled     | boolean

    *Required
--}}

@php
    if($errors->has($name)) :
        $placeholder =  $errors->first($name);
    endif
@endphp

<div class="input-group">

    <input type="{{ $type }}"
           {{ $disabled ? 'disabled' : '' }}
           aria-describedby="input-aria-{{ $name }}"
           name="{{ $name }}"
           {{ isset($min) ? 'min='.$min : '' }}
           class="{{ isset($class) ? $class : '' }} {{ $errors->has($name) ? 'placeholder-error red-b' : '' }}"
           id="form-input-{{ $name }}"
           value="{{ isset($m_value) ? $m_value : '' }}"
           placeholder="{{ isset($placeholder) ? $placeholder : '' }}">

    @if(isset($append))
        <div class="input-group-append">
            <span class="input-group-text" id="input-aria-{{ $name }}">{{ $append }}</span>
        </div>
    @endif
</div>



