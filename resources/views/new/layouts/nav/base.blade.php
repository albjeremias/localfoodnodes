{{--@if (Auth::user() && Auth::user()->active)--}}

@if(!isset($no_nav))
    <div id="nav-container" class="{{ !isset($transparent_nav) ? 'bg-main-primary' : 'bg-color-trans' }} fixed-top">

        <nav class="navbar navbar-light navbar-expand-md">
            <a class="navbar-brand" href="/">
                <img class="nav-logo" src="/images/nav-logo.png">
            </a>

            <button class="navbar-toggler mr-2" type="button" data-toggle="collapse" data-target="#main-navbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="main-navbar">
                <ul class="navbar-nav mr-auto main-nav">
                    @if(isset($public_nav))
                        @include('new.layouts.nav.public')
                    @else
                        @include('new.layouts.nav.account')
                    @endif

                </ul>

                <ul class="navbar-nav ml-auto">
                    <!-- Visible links on mobile -->
                    <li class="nav-item d-sm-block d-md-none">
                        <a class="nav-link" href="/login">{{ trans('public/nav.login') }}</a>
                    </li>
                    <li class="nav-item d-sm-block d-md-none">
                        <a class="nav-link" href="/account/user/create">{{ trans('public/nav.create') }}</a>
                    </li>

                    <!-- Fast login hidden on mobile -->
                    @if (Auth::user())
                        <li class="d-none d-md-block">
                            <a href="#" class="nav-link text-capitalize px-0">
                                {{ Auth::user()->name }}
                            </a>
                        </li>

                        <li class="d-none d-md-block my-auto px-4">
                            <i class="fa fa-question-circle icon-38" aria-hidden="true"></i>
                        </li>

                        <li class="d-none d-md-block my-auto px-0">
                            <i class="fa fa-sign-out icon-38" aria-hidden="true"></i>
                        </li>
                    @else
                        <li class="d-none d-md-block">
                            <a href="#" class="nav-link">
                                {{ trans('public/nav.login') }}
                            </a>
                        </li>

                        <li class="d-none d-md-block px-3">
                            <a href="#" class="btn btn-primary">
                                {{ trans('public/nav.create') }}
                            </a>
                        </li>

                        <li class="dropdown d-none d-md-block mr-2">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
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

        {{-- EXTEND NAVBAR TO SHOW BREADCRUMBS --}}
        @if(isset($bread_type))
            <div class="bg-main-primary wc d-none d-sm-block nav-breadcrumb mb-4">
                <ul class="row list-inline mb-0 align-items-center">
                    <li class="list-inline-item mr-4">
                        <p class="my-auto">{{ $bread_type }}</p>
                    </li>

                    <li class="list-inline-item mr-4">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </li>

                    <li class="list-inline-item mr-4">
                        <h3 class="mb-0">{{ $bread_result }}</h3>
                    </li>
                </ul>
            </div>
        @endif

        {{-- EXTEND NAVBAR TO SHOW PAGE TITLE --}}
        @if(isset($title))
            <div class="bg-main-primary wc d-none d-sm-block nav-breadcrumb mb-4">
                <ul class="row list-inline mb-0 align-items-center">
                    <li class="list-inline-item mr-4">
                        <h3 class="mb-0">{{ $title }}</h3>
                    </li>
                </ul>
            </div>
        @endif

        {{-- EXTEND NAVBAR TO SHOW A SUB NAVBAR --}}
        @if(isset($sub_nav))
            <div class="bg-main-primary wc d-none d-sm-block text-uppercase sub-nav">
                <ul class="list-inline mt-2">
                    @foreach($sub_nav as $nav_item)
                        <li class="list-inline-item">
                            <a class="{{ $sub_nav_active == $loop->index ? 'sub-nav-active' : 'wc' }} px-3" href="#">{{ $nav_item }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif



