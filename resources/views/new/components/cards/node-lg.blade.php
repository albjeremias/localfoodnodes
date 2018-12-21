<div class="row node-lg box-shadow-square mb-5">
    <div class="col-lg-11 my-3">
        <h4 class="rc mb-0">{{ $name }}</h4>
        <p class="black-54">{{ $address }}</p>

        <ul class="list-inline mb-0 black-54">
            <li class="list-inline-item mr-2 mr-md-4">
                <i class="fa fa-users mr-2" aria-hidden="true"></i>
                <span class="">{{ $users }}</span>
                <p class="d-none d-sm-block"><small>{{ trans('admin/user.users') }}</small></p>
            </li>

            <li class="list-inline-item mx-2 mx-md-4">
                <i class="fa fa-home mr-2" aria-hidden="true"></i>
                <span class="">{{ $producers }}</span>
                <p class="d-none d-sm-block"><small>{{ trans('admin/user.producers') }}</small></p>
            </li>

            <li class="list-inline-item mx-2 mx-md-4">
                <i class="fa fa-shopping-basket mr-2" aria-hidden="true"></i>
                <span class="">{{ $products_count }}</span>
                <p class="d-none d-sm-block"><small>{{ trans('admin/user.products_for_sale') }}</small></p>
            </li>

            <li class="list-inline-item ml-2 ml-md-4">
                <i class="fa fa-map-marker mr-2" aria-hidden="true"></i>
                <span class="">{{ $average_dist }}</span>
                <p class="d-none d-sm-block"><small>{{ trans('admin/user.average_distance') }}</small></p>
            </li>
        </ul>

        <div class="mb-3 mt-3 mt-sm-0">
            @foreach($products as $product)
                <small href="#" class="badge badge-pill badge-danger rc">{{ $product }}</small>
            @endforeach
        </div>

        <a class="visit-link" href="#">{{ trans('admin/user.visit_node') }}</a>
    </div>

    <div class="col-lg-5 order-first order-lg-last image" style="background-image: url('{{ $image }}')"></div>
</div>