{{--@if (Auth::user() && Auth::user()->active)--}}

@if(!isset($no_nav))
    <div id="nav-container" class="{{ !isset($transparent_nav) ? 'bg-main-primary' : 'bg-color-trans' }} fixed-top">

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


                    <!-- Fast login hidden on mobile -->
                    {{-- User is authed and is not using the transparent navbar --}}
                    @if (Auth::user() && !isset($transparent_nav))
                        <li class="d-none d-lg-block my-auto px-0">
                            <a href="/account/user/edit" class="wc nav-link text-transform-none px-0">
                                <i class="fa fa-user-circle icon-38 icon-14em" aria-hidden="true"></i>
                            </a>
                        </li>

                        <li class="d-none d-lg-block my-auto px-4">
                            <a href="#">
                                <i class="fa fa-question-circle icon-38" aria-hidden="true"></i>
                            </a>
                        </li>

                        <li class="d-none d-lg-block my-auto px-0">
                            <a href="/logout">
                                <i class="fa fa-sign-out icon-38" aria-hidden="true"></i>
                            </a>
                        </li>

                    {{-- User is NOT authed and is using the transparent navbar --}}
                    @elseif(!Auth::user() && isset($transparent_nav))
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

                        {{-- Mobile only --}}
                        <li class="d-lg-none">
                            <a class="nav-link wc" href="/login">{{ trans('public/nav.login') }}</a>
                        </li>

                        <li class="d-lg-none">
                            <a class="nav-link wc" href="/account/user/create">{{ trans('public/nav.create') }}</a>
                        </li>

                    {{-- User is authed and is using the transparent navbar --}}
                    @elseif(Auth::user() && isset($transparent_nav))

                        <li class="d-none d-lg-block">
                            <a href="/logout" class="nav-link">
                                <span class="wc hover-wbb pb-2">{{ trans('admin/user-nav.logout') }}</span>
                            </a>
                        </li>

                        <li class="d-none d-lg-block px-3">
                            <a href="/account/user" class="btn btn-primary">
                                {{ trans('public/nav.dashboard') }}
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

                        {{-- Mobile only --}}
                        <li class="d-lg-none">
                            <a class="nav-link wc" href="/account/user">{{ trans('public/nav.dashboard') }}</a>
                        </li>
                        <li class="d-lg-none">
                            <a class="nav-link wc" href="/logout">{{ trans('admin/user-nav.logout') }}</a>
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



