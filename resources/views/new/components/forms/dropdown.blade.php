{{--
    -Form Dropdown Component-

    *name        | string
    *class       | string
    *options     | array
    *value       | boolean
    *val_key     | boolean
    label        | string
    placeholder  | string

    *Required
--}}

@if(isset($label))
    <label for="form-dropwdown-{{ $name }}">{{ $label }}</label>
@endif

<select class="{{ $class }}" name="{{ $name }}">
    @if(isset($placeholder))
        <option>{{ $placeholder }}</option>
    @endif

    @if(!$value)
        @foreach ($options as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    @else
        @foreach ($options as $key => $value)
            <option value="{{ $key }}">{{ $val_key ? $value : $key }}</option>
        @endforeach
    @endif
</select>