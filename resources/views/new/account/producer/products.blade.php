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

@endsection
