<div class="box-shadow py-3 mb-1">
    <div class="container py-2">
        <ul class="d-flex px-0 my-auto">
            @foreach($steps as $step)
                <div class="d-inline-flex">
                    <small class="{{ $loop->index > $active ? 'bg-black-54 wc' : 'black-87 bg-main-accent' }} number-circle">{{ $loop->index+1 }}</small>
                    <small class="mx-2 black-87" href="#">{{ $step }}</small>
                </div>

                @if(count($steps) > $loop->index+1)
                    <div class="col">
                        <div class="producer-create-progress" href="#"></div>
                    </div>
                @endif
            @endforeach
        </ul>
    </div>
</div>