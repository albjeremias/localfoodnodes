<table class="table table-hover">
    <thead border="0">
    <tr>
        @foreach($items[0] as $item => $value)
            <th
                scope="col"
                class="{{ $loop->index == 0 ? 'text-center pl-0' : '' }}">
                {{ trans('public/pages/explore.' . $item) }}
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>

    @foreach($items as $item)
        <tr>
            @foreach($item as $key => $value)
                @if($loop->index == 0)
                    <td class="text-center pl-0"><i class="fa fa-{{ $item[$key] }} icon-38" aria-hidden="true"></i></td>
                @else
                    <td>{{ $item[$key] }}</td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>