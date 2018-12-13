{{--
    -Form Table Component-

    *items  | array

    *Required
--}}

<table class="table table-hover {{ isset($table_classes) ? $table_classes : ''}}">
    <thead border="0">
    <tr>
        @foreach($items[0] as $item)
            <th
                scope="col"
                class="{{ isset($item['tr_class']) ? $item['tr_class'] : '' }}">
                {{ $item['tr'] }}
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>

    @foreach($items as $item)
        <tr>
            @foreach($item as $value)
                @php
                    if (!isset($value['disabled'])) $value['disabled'] = false;
                    if (!isset($value['class'])) $value['class'] = false;
                    if (!isset($value['value'])) $value['value'] = false;
                @endphp

                <td>
                    @switch($value['type'])
                        @case('checkbox')
                            @include('new.components.tables.form-types.checkbox', [
                                'name'     => $value['name'],
                                'checked'  => $value['checked'],
                                'disabled' => $value['disabled']
                            ])
                        @break

                        @case('number')
                            @include('new.components.tables.form-types.input', [
                                'name'     => $value['name'],
                                'type'     => $value['type'],
                                'disabled' => $value['disabled'],
                                'm_value'  => $value['value'],
                                'class'    => $value['class']
                            ])
                        @break

                        @case('text')
                            @include('new.components.tables.form-types.input', [
                                'name'     => $value['name'],
                                'type'     => $value['type'],
                                'disabled' => $value['disabled'],
                                'm_value'  => $value['value'],
                                'class'    => $value['class']
                            ])
                        @break

                        @case('image')
                            @include('new.components.tables.form-types.image', [
                                'name'     => $value['name'],
                                'type'     => $value['type'],
                                'm_value'  => $value['value'],
                                'class'    => $value['class']
                            ])
                        @break

                        @case('dropdown')
                            @include('new.components.tables.form-types.dropdown', [
                                'name'     => $value['name'],
                                'disabled' => $value['disabled'],
                                'options'  => $value['options'],
                                'value'    => $value['value'],
                                'val_key'  => $value['val_key'],
                            ])
                        @break
                    @endswitch
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>