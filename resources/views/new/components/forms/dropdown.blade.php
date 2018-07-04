{{--
    -Form Dropdown Component-

    label        | string
    *name        | string
    *class       | string
    *placeholder | string
    *options     | array
    value        | boolean

    *Required
--}}

@if(isset($label))
    <label for="form-dropwdown-{{ $name }}">{{ $label }}</label>
@endif

<select class="{{ $class }}">
    <option>{{ $placeholder }}</option>

    @if(!isset($value) && !$value)
        @foreach ($options as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    @else
        @foreach ($options as $key => $value)
            <option value="{{ $key }}">{{ $key }}</option>
        @endforeach
    @endif
</select>