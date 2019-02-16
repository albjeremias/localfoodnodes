{{--
    -Form Dropdown Component-

    *name        | string
    *value       | boolean
    *options     | array
    selected     | string
    val_key      | boolean
    class        | string
    label        | string
    placeholder  | string

    *Required
--}}

@php
    $selected = isset($selected) ? $selected : false;
    $val_key = $value && isset($val_key) ? $val_key : true ;
@endphp

@if(isset($label))
    <label for="form-dropwdown-{{ $name }}">{{ $label }}</label>
@endif

<select class="form-control {{ isset($class) ? $class : '' }}" name="{{ $name }}" autocomplete="off">
    @if(isset($placeholder))
        <option value="">{{ $placeholder }}</option>
    @endif

    @if(!$value)
        @foreach ($options as $option)
            <option {{ $selected == $option ? 'selected' : '' }} value="{{ $option }}">{{ $option }}</option>
        @endforeach
    @else
        @foreach ($options as $key => $value)
            <option {{ $selected == $key ? 'selected' : '' }} value="{{ $key }}">{{ $val_key ? $value : $key }}</option>
        @endforeach
    @endif
</select>