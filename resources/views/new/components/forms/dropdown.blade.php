{{--
    -Form Dropdown Component-

    *label       | string
    *name        | string
    *class       | string
    *placeholder | string
    *options     | array

    *Required
--}}

<label for="form-dropwdown-{{ $name }}">{{ $label }}</label>

<select class="{{ $class }}">
    <option>{{ $placeholder }}</option>

    @foreach ($options as $option)
        <option value="{{ $option }}">{{ $option }}</option>
    @endforeach
</select>