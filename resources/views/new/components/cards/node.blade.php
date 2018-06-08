<div class="card-node-container my-5">
    <div class="node-image image p-3" style="background-image: url('/images/shutterstock_271622087.jpg')">
        <span class="btn btn-dark">
            <i class="fa fa-clock-o" aria-hidden="true"></i>
            {{ $time }}
        </span>
    </div>

    <div class="node-content p-3">
        <span class="float-right">
            <i class="fa fa-users icon-38 icon-small" aria-hidden="true"></i>
            <small>{{ $producers }}</small>
        </span>

        <h4 class="mb-0">{{ $name }}</h4>
        <small>{{ $address  }}</small>

        <p class="mt-3">
            <small>{{ $bio }}</small>
        </p>

        <hr>
        <a class="rc" href="{{ $link }}">BESÖK NOD</a>
        <i class="product-items-share fa fa-share icon-38 float-right" aria-hidden="true"></i>
    </div>
</div>