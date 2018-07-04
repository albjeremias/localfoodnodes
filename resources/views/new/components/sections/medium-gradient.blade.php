<section class="medium-gradient {{ $global }} bg-img-{{ $image }} {{ $sm_bg }}">
    <div class="gradient {{ $inverted ? 'inverted-' : 'normal-' }}{{ $color }} gradient-{{ $color }}">
        <div class="container">
            <div class="row pt-3">
                <div class="{{ $inverted ? 'col-sm-7 offset-sm-9 col-lg-6 offset-lg-10' : 'col-sm-9 col-lg-6' }} pt-5 text-center text-sm-left">
                    <h2>{{ trans($heading) }}</h2>
                    <p>{{ trans($paragraph) }}</p>
                    <a class="btn btn-{{ $button }} mt-4 {{ $button_swap ? 'button-main' : '' }}" href="#">{{ trans($button_text) }}</a>
                    @if($button_swap)
                        <a class="btn btn-{{ $button_swap }} mt-4 d-sm-none" href="#">{{ trans($button_text) }}</a>
                    @endif
                </div>
            </div>
        </div>
        @include('new.components.arrow', ['dark' => false, 'absolute' => true, 'anchor' => $anchor])
    </div>
</section>