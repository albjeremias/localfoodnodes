<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - Local Food Nodes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ trans('public/index.meta_keywords') }}">
    <meta name="description" content="{!! $fbDescription ?? 'Local Food Nodes connects local food producers to local food consumers as well as strengthening those relationships that already exist. We enable direct transactions, resilient communities and regain control over what we eat and how it is produced. A desire to make food local again.' !!}">

    <!-- Facebook meta -->
    <meta property="og:url" content="{{ $shareUrl ?? app('url')->to('/') }}">
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ $shareTitle ?? 'Local Food Nodes' }}">
    <meta property="og:description" content="{!! $shareDescription ?? 'Local Food Nodes connects local food producers to local food consumers as well as strengthening those relationships that already exist. We enable direct transactions, resilient communities and regain control over what we eat and how it is produced. A desire to make food local again.' !!}" />
    <meta property="og:image" content="{{ $shareImage ?? URL::asset('images/facebook-share.jpg') }}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- CSS -->
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.png">
    <link rel="stylesheet" href="/css/leaflet/leaflet.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/public.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/slick.css') }}"/>
</head>
<body class="position-relative public {{ Auth::check() && Auth::user()->active ? 'logged-in' : '' }}">

<div id="fb-root"></div>
<div class="page">
    @include('new.layouts.nav.base')
{{--    @include('account.user-nav-mobile')--}}
    <div class="content">
        @include('shared.system-messages')
        @yield('content')
    </div>
</div>

@yield('modal')

@include('new.public.footer')

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

@if(isset($script))
    <script src="{{ mix('js/' . $script .'.js') }}"></script>
@else
    <script src="{{ mix('/js/new.js') }}"></script>
@endif

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('set', 'anonymizeIp', true);
    ga('create', 'UA-90169652-1', 'auto');
    ga('send', 'pageview');

</script>
{{-- <script src="https://embed.small.chat/T0Z3AQJK1G5Q08NBRS.js"></script> --}}
</body>
</html>
