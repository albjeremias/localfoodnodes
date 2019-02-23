@if(!isset($no_nav))
    <footer class="container-fluid footer">
        <div class="container pt-5">

            <div class="row d-flex">
                <div class="col-16 col-md-4 mb-3">
                    <ul class="list-unstyled">
                        <li class="nav-item mb-1">
                            <a class="nav-link" href="mailto:info@localfoodnodes.org">Local Food Nodes</a>
                        </li>
                        <li class="nav-item mb-1">
                            Hantverksgatan 5, 268 68 Röstånga
                        </li>
                        <li class="nav-item mb-1">
                           Org.nr: 769633-6598
                        </li>
                        <li class="nav-item d-flex mt-3">
                            <a class="nav-link mr-2" href="https://www.facebook.com/localfoodnodes">
                                <i class="icon fab fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a class="nav-link" href="https://github.com/localfoodnodes">
                                <i class="icon fab fa-github" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-16 col-md-8 mb-3 text-md-center">
                    {{ __('We are creating local food nodes in order to connect local food producers to local food consumers as well as strengthening those relationships that already exist. We want to enable direct transactions, resilient communities and regain control over what we eat and how it is produced. A desire to make food local again. ') }}
                </div>

                <div class="col-16 col-md-4 mb-3 text-md-right">
                    <ul class="list-unstyled">
                        <li class="nav-item mb-1">
                            <a class="nav-link" href="{{ route('find_out_more') }}">{{ __('Find out more') }}</a>
                        </li>

                        <li class="nav-item mb-1">
                            <a class="nav-link" href="{{ route('membership') }}">{{ __('Membership') }}</a>
                        </li>

                        <li class="nav-item mb-1">
                            <a class="nav-link" href="{{ route('economy') }}">{{ __('Economy') }}</a>
                        </li>

                        <li class="nav-item mb-1">
                            <a class="nav-link" href="{{ route('vision') }}">{{ __('Vision') }}</a>
                        </li>

                        <li class="nav-item mb-1">
                            <a class="nav-link" href="{{ route('statistics') }}">{{ __('Statistics') }}</a>
                        </li>

                        <li class="nav-item mb-1">
                            <a class="nav-link" href="{{ route('faq') }}">{{ __('FAQ') }}</a>
                        </li>

                        <li class="nav-item mb-1">
                            <a class="nav-link" href="">{{ __('GDPR') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex col-16 mb-3">
                    <div class="m-sm-auto">
                        <img src="/images/nav-logo.png">
                    </div>
                </div>

            </div>
        </div>
    </footer>
@endif
