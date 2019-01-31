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
                @if(isset($value['href']))
                    <td><a href="{{ $value['href'] }}" class="{{ isset($value['class']) ? $value['class'] : '' }} rc">{{ $value['value'] }}</a></td>
                @elseif(isset($value['badge']))
                    <td class="">
                        <div class="{{ isset($value['class']) ? $value['class'] : '' }}">
                            {!! $value['value']  !!}
                        </div>
                    </td>
                @else
                    <td class="{{ isset($value['class']) ? $value['class'] : '' }}">{!! $value['value']  !!}</td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>