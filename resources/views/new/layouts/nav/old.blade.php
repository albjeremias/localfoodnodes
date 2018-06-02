{{--@if (!Auth::check() || (Auth::user() && Auth::user()->active !== true))--}}
@if (!env('DEV_AUTH'))

    <nav class="navbar fixed-top navbar-light navbar-expand-md bg-color-trans">
        <a class="navbar-brand" href="/">
            <img class="nav-logo" src="/images/nav-logo.png">
        </a>

        <button class="navbar-toggler mr-2" type="button" data-toggle="collapse" data-target="#main-navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="main-navbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item d-sm-none d-md-block">
                    <a class="nav-link" href="/membership">{{ trans('public/nav.how_it_works') }}</a>
                </li>
                <li class="nav-item d-sm-none d-md-block">
                    <a class="nav-link" href="/membership">{{ trans('public/nav.membership_2') }}</a>
                </li>
                <li class="nav-item d-sm-none d-md-block">
                    <a class="nav-link" href="/economy">{{ trans('public/nav.economy_2') }}</a>
                </li>

                <li class="nav-item d-sm-none d-md-block">
                    <a class="nav-link" href="/economy">{{ trans('public/nav.find_out_more') }}</a>
                </li>
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

                <!-- Fast login hidden on mobile -->
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

            </ul>
        </div>
    </nav>
@endif
