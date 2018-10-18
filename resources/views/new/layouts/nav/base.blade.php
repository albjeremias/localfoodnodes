{{--@if (Auth::user() && Auth::user()->active)--}}

@if(!isset($no_nav))
    <div id="nav-container"
         class="{{ !isset($transparent_nav) ? 'bg-main-primary' : 'bg-color-trans' }} fixed-top">

        <nav class="navbar navbar-light navbar-expand-lg text-center text-lg-left mb-lg-0 pb-2 container">
            <a class="navbar-brand" href="/">
                <img class="nav-logo" src="/images/nav-logo.png">
            </a>

            <button class="navbar-toggler mr-2" type="button" data-toggle="collapse" data-target="#main-navbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="main-navbar">
                <ul class="navbar-nav mr-auto main-nav mt-5 mt-lg-0">
                    @if(isset($public_nav))
                        @include('new.layouts.nav.types.public')
                    @else
                        @include('new.layouts.nav.types.account')
                    @endif
                </ul>

                <ul class="navbar-nav ml-auto mb-5 mb-lg-0 mt-3 mt-lg-0">
                    <!-- Visible links on mobile -->
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="/login">{{ trans('public/nav.login') }}</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="/account/user/create">{{ trans('public/nav.create') }}</a>
                    </li>

                    <!-- Fast login hidden on mobile -->
                    @if (Auth::user() && !isset($transparent_nav))
                        <li class="d-none d-lg-block">
                            <a href="/account/user/edit" class="wc nav-link text-capitalize px-0">
                                {{ Auth::user()->name }}
                            </a>
                        </li>

                        <li class="d-none d-lg-block my-auto px-4">
                            <i class="fa fa-question-circle icon-38" aria-hidden="true"></i>
                        </li>

                        <li class="d-none d-lg-block my-auto px-0">
                            <a href="/logout">
                                <i class="fa fa-sign-out icon-38" aria-hidden="true"></i>
                            </a>
                        </li>
                    @else
                        <li class="d-none d-lg-block">
                            <a href="/login" class="nav-link">
                                <span class="wc hover-wbb pb-2">{{ trans('public/nav.login') }}</span>
                            </a>
                        </li>

                        <li class="d-none d-lg-block px-3">
                            <a href="/register" class="btn btn-primary">
                                {{ trans('public/nav.create') }}
                            </a>
                        </li>

                        <li class="dropdown d-none d-lg-block mr-2">
                            <a href="#" class="nav-link dropdown-toggle wc" data-toggle="dropdown">
                                {{ trans('public/nav.lang_swe') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach (config('app.locales') as $key => $value)
                                    <a class="dropdown-item" href="/settings/locale/{{ $key }}">{{ $value }}</a>
                                @endforeach
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        {{-- Extend navbar - Breadcrumbs --}}
        @include('new.layouts.nav.partials.breadcrumbs')

        {{-- Extend navbar - Page title --}}
        @include('new.layouts.nav.partials.page-title')

        {{-- Extend navbar - Sub Menu --}}
        @include('new.layouts.nav.sub.sub-menu')
    </div>
@endif

<script>
    $('.navbar-toggler').click(function () {
        if (!$('#nav-container').hasClass('bg-main-primary')) {
            $('#nav-container').toggleClass('bg-black-87');
        }
    });
</script>



