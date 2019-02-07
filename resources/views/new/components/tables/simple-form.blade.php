{{--
    -Form Simple Table Component-

    *items  | array

    *Required
--}}

<table class="table table-striped">
    <tbody>
    @foreach($items as $item)

        @php
            if (!isset($item['disabled'])) $item['disabled'] = false;
            if (!isset($item['class'])) $item['class'] = false;
            if (!isset($item['value'])) $item['value'] = false;
        @endphp

        <tr>
            <td class="font-weight-bold w-50 {{ $item['disabled'] ? '' : '' }}">{{ $item['text'] }}</td>
            <td>
                @switch($item['type'])
                    @case('checkbox')
                        @include('new.components.tables.form-types.checkbox', [
                            'name'     => $item['name'],
                            'checked'  => $item['checked'],
                            'disabled' => $item['disabled']
                        ])
                    @break

                    @case('number')
                        @include('new.components.tables.form-types.input', [
                            'name'     => $item['name'],
                            'type'     => $item['type'],
                            'disabled' => $item['disabled'],
                            'm_value'  => $item['value'],
                            'class'    => $item['class']
                        ])
                    @break

                    @case('text')
                        @include('new.components.tables.form-types.input', [
                            'name'     => $item['name'],
                            'type'     => $item['type'],
                            'disabled' => $item['disabled'],
                            'm_value'  => $item['value'],
                            'class'    => $item['class']
                        ])
                    @break

                    @case('dropdown')
                        @include('new.components.tables.form-types.dropdown', [
                            'name'     => $item['name'],
                            'disabled' => $item['disabled'],
                            'options'  => $item['options'],
                            'm_value'  => $item['value'],
                            'val_key'  => $item['val_key'],
                        ])
                    @break
                @endswitch
            </td>
        </tr>
    @endforeach
    </tbody>
</table>