<table class="table table-hover {{ isset($table_classes) ? $table_classes : ''}}">
    <tbody>
    @foreach($items as $key => $value)
        <tr>
            <td class="font-weight-bold">{!! $key  !!}</td>
            <td>{!! $value  !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>