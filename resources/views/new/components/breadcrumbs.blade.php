@php
    $length = count($crumbs);
    $count = 1;
@endphp

@foreach($crumbs as $label => $crumb)
    @if($length != $count)
        @if($count == 1)
            <i class="black-54 fa fa-{{ $crumb['icon'] }}"></i>
        @endif
        <a href="{{ $crumb['link'] }}"><span class="black-54 font-weight-light">{{ $label }}</span></a>
        <small><i class="fa fa-angle-right mx-1"></i></small>
    @else
        <small><span class="font-weight-bold">{{ $label }}</span></small>
    @endif
    @php($count++)
@endforeach