@if (isset($breadcrumbs))
    <div class="bg-main-primary wc mb-4 d-none d-lg-block container">
        <ul class="list-inline mb-0 align-items-center nav-breadcrumb">
            @include('new.components.breadcrumbs')
        </ul>
    </div>
@endif