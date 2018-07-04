@if(isset($nav_title))
    <div class="bg-main-primary wc nav-breadcrumb mb-4 d-none d-lg-block">
        <ul class="list-inline mb-0 align-items-center">
            <li class="list-inline-item mr-4">
                <h3 class="mb-0">{{ $nav_title }}</h3>
            </li>

            <li class="list-inline-item mr-4 float-right">
                @include('new.layouts.nav.partials.search')
            </li>

        </ul>
    </div>
@endif