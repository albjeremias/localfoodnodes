{{--
    -Information tooltip with icon-

    *text        | string
    placement    | [top | right | bottom | left] string
    class        | string

    *Required
--}}

@php
    $placement = !empty($placement) ? $placement : 'bottom';
    $class = !empty($class) ? $class : '';
@endphp

<i class="ml-2 fa fa-info-circle {{ $class }}" data-toggle="tooltip" data-placement="{{ $placement }}" title="{{ $text }}"></i>