{{--
    -Arrow Component-

    classes  | string
    absolute | string
    *dark    | boolean
    absolute | boolean
    *anchor   | string

    *Required
--}}

<div class="arrow-container w-100 {{ isset($classes) ? $classes : '' }}{{ isset($absolute) ? 'arrow-absolute' : '' }}">
    <a href="#{{ $anchor }}"
       class="mx-auto smooth-scroll d-flex icon-circle rounded-circle {{ $dark ? 'bg-black-38 nb' : '' }}">
        <i class="fa fa-angle-down arrow m-auto" aria-hidden="true"></i>
    </a>
</div>
