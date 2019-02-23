@extends('new.account.layout',
[
    'sub_nav'        => 'producer',
    'sub_nav_active' => 1,
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')

    <div class="bg-shell">
        <div class="container nm">
            <!-- PRODUCTS -->
            <section class="py-5" id="products-administration">
                <products-administration-index
                    :producer="{{ $producer }}"
                    lang="{{ app()->getLocale() }}"
                ></products-administration-index>
            </section>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" />

    <script>
        $(document).ready(function(){
            $('.slick-container').slick({
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 7,
                slidesToScroll: 7,
            });
        });
    </script>
@endsection
