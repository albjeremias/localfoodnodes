@if(isset($bread_type))
    <div class="bg-main-primary wc mb-4 d-none d-lg-block container">
        <ul class="list-inline mb-0 align-items-center nav-breadcrumb">
            <li class="list-inline-item mr-4">
                <p class="my-auto">{{ $bread_type }}</p>
            </li>

            <li class="list-inline-item mr-4">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </li>

            <li class="list-inline-item mr-4">
                <h3 class="mb-0">{{ $bread_result }}</h3>
            </li>

            <li class="list-inline-item mr-4 float-right">
                @include('new.layouts.nav.partials.search')
            </li>
        </ul>
    </div>
@endif