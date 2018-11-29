<table class="table table-striped {{ isset($table_classes) ? $table_classes : ''}}">
    <tbody>
    @foreach($items as $key => $value)
        <tr>
            <td class="{{ $bold ? 'font-weight-bold' : '' }} w-50">{!! $key  !!}</td>
            <td>{!! $value  !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>