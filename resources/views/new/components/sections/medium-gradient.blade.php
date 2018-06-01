<section class="medium-gradient {{ $global }} bg-img-{{ $image }} ">
    <div class="gradient {{ $inverted ? 'inverted-' : 'normal-' }}{{ $color }} gradient-{{ $color }}">
        <div class="container">
            <div class="row">
                <div class="col-md-6 {{ $inverted ? 'offset-10' : '' }} pt-6">
                    <h2>{{ trans($heading) }}</h2>
                    <p>{{ trans($paragraph) }}</p>
                    <a class="btn btn-{{ $button }} mt-4" href="#">{{ trans($button_text) }}</a>
                </div>
            </div>
        </div>
    </div>
    @include('new.components.arrow', ['dark' => false])
</section>