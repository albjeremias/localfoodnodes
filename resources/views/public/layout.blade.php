<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title') - Local Food Nodes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="keywords" content="{{ trans('public/index.meta_keywords') }}">
        <meta name="description" content="{!! $fbDescription or 'Local Food Nodes connects local food producers to local food consumers as well as strengthening those relationships that already exist. We enable direct transactions, resilient communities and regain control over what we eat and how it is produced. A desire to make food local again.' !!}">

        <!-- Facebook meta -->
        <meta property="og:url" content="{{ $shareUrl or app('url')->to('/') }}">
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="{{ $shareTitle or 'Local Food Nodes' }}">
        <meta property="og:description" content="{!! $shareDescription or 'Local Food Nodes connects local food producers to local food consumers as well as strengthening those relationships that already exist. We enable direct transactions, resilient communities and regain control over what we eat and how it is produced. A desire to make food local again.' !!}" />
        <meta property="og:image" content="{{ $shareImage or URL::asset('images/facebook-share.jpg') }}">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script>
            window.lang = '{{ app()->getLocale() }}';
        </script>

        <!-- CSS -->
        <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.png">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:200,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ mix('css/public.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/jquery.fancybox.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/slick.css') }}"/>
    </head>
    <body class="public {{ $viewName }} {{ Auth::check() && Auth::user()->active ? 'logged-in' : '' }}">
        <div id="fb-root"></div>
        <div class="page">
            @include('account.user-nav')
            @include('public.nav')
            @include('account.user-nav-mobile')
            <div class="content">
                <div class="container-fluid">
                    @include('shared.errors')
                    @yield('content')
                </div>
            </div>
        </div>

        @yield('modal')

        @include('public.footer')

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <script src="{{ URL::asset('js/jquery.fancybox.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/slick.min.js') }}"></script>
        <script>
            $(function() {
                $('.slick-slider-wrapper').slick({
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    speed: 1000,
                });

                // Enable tooptip
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('set', 'anonymizeIp', true);
            ga('create', 'UA-90169652-1', 'auto');
            ga('send', 'pageview');

        </script>
        <script src="https://embed.small.chat/T0Z3AQJK1G5Q08NBRS.js"></script>
    </body>
</html>
