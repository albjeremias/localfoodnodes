@if(!isset($no_nav))
    <section class="container-fluid footer">
        <div class="container pt-5">

            <div class="row d-flex">
                <div class="col-16 col-sm-4">
                    <a class="d-block" href="mailto:info@localfoodnodes.org">info@localfoodnodes.org</a>
                    <a class="d-block" href="#">+46 735 325945</a>
                    <a class="d-block" href="#">Hantverksgatan 5, 268 68 Röstånga</a>
                    <a class="d-block" href="#">Org.nr: 769633-6598</a>

                    <div>
                        <a class="d-block" href="https://www.facebook.com/localfoodnodes">
                            <i class="icon black-54 fa fa-facebook-official" aria-hidden="true"></i>
                        </a>

                        <a class="d-block" href="https://github.com/localfoodnodes">
                            <i class="icon black-54 fa fa-git-square" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="col-16 col-sm-7">
                    {{ __('We are creating local food nodes in order to connect local food producers to local food consumers as well as strengthening those relationships that already exist. We want to enable direct transactions, resilient communities and regain control over what we eat and how it is produced. A desire to make food local again. ') }}
                </div>

                <div class="col-8 col-sm-4 offset-sm-1">
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('find_out_more') }}"><span class="hover-wbb pb-2 wc">{{ __('Find out more') }}</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('membership') }}"><span class="hover-wbb pb-2 wc">{{ __('Membership') }}</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('economy') }}"><span class="hover-wbb pb-2 wc">{{ __('Economy') }}</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vision') }}"><span class="hover-wbb pb-2 wc">{{ __('Vision') }}</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('statistics') }}"><span class="hover-wbb pb-2 wc">{{ __('Statistics') }}</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('faq') }}"><span class="hover-wbb pb-2 wc">{{ __('FAQ') }}</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href=""><span class="hover-wbb pb-2 wc">{{ __('GDPR') }}</span></a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex col-16 order-last col-sm-4 order-sm-0 col-xl-16 order-xl-last mt-xl-5">
                    <div class="ml-2 my-3 m-sm-auto">
                        <img src="/images/nav-logo-dark.png">
                    </div>
                </div>

            </div>
        </div>
    </section>
@endif
