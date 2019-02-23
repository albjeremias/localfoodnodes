@php
    $length = count($breadcrumbs);
    $count = 1;
@endphp

@foreach ($breadcrumbs as $label => $link)
    @if ($length != $count)
        <li class="list-inline-item mr-4">
            <a href="{{ $link }}" class="wc">{{ $label }}</a>
        </li>

        <li class="list-inline-item mr-4">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </li>
    @else
        <li class="list-inline-item mr-4">
            <h3 class="mb-0">{{ $label }}</h3>
        </li>
    @endif
    @php($count++)
@endforeach