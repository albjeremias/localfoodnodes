{{--
    -Form table Dropdown Component-

    *name        | string
    *options     | array
    *value       | boolean
    *val_key     | boolean
    placeholder  | string
    *disabled    | boolean

    *Required
--}}

<select id="dropdown-{{ $name }}" {{ $disabled ? 'disabled' : '' }} class="form-control form-control-sm w-50" name="{{ $name }}">
    @if(isset($placeholder))
        <option>{{ $placeholder }}</option>
    @endif

    @if(!$m_value)
        @foreach ($options as $option)
            <option value="{{ $option }}" {{ $option === $m_value ? 'selected' : '' }}>{{ $option }}</option>
        @endforeach
    @else
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" {{ $value === $m_value ? 'selected' : '' }}>{{ $val_key ? $value : $key }}</option>
        @endforeach
    @endif
</select>