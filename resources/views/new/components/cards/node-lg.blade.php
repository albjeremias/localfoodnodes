<div class="row bby node-lg">
    <div class="col-11 my-3">
        <h4 class="mb-0">{{ $name }}</h4>
        <p class="black-54">{{ $address }}</p>

        <ul class="list-inline mb-0 black-54">
            <li class="list-inline-item mr-4">
                <i class="fa fa-users mr-2" aria-hidden="true"></i>
                <span class="">{{ $users }}</span>
                <p><small>Användare</small></p>
            </li>

            <li class="list-inline-item mx-4">
                <i class="fa fa-home mr-2" aria-hidden="true"></i>
                <span class="">{{ $producers }}</span>
                <p><small>Producenter</small></p>
            </li>

            <li class="list-inline-item mx-4">
                <i class="fa fa-shopping-basket mr-2" aria-hidden="true"></i>
                <span class="">{{ $products_count }}</span>
                <p><small>Produkter till salu</small></p>
            </li>

            <li class="list-inline-item ml-4">
                <i class="fa fa-map-marker mr-2" aria-hidden="true"></i>
                <span class="">{{ $average_dist }}</span>
                <p><small>Snittavstånd till producent</small></p>
            </li>
        </ul>

        <div class="mb-3">
            @foreach($products as $product)
                <small href="#" class="badge badge-pill badge-danger rc">{{ $product }}</small>
            @endforeach
        </div>

        <a class="rc" href="#">BESÖK NOD</a>

    </div>

    <div class="col-5 image" style="background-image: url({{ $image }})"></div>
</div>