@extends('new.account.layout',
[
    'nav_title'      => trans('admin/user.nav_title'),
    'sub_nav'        => 'producer',
    'sub_nav_active' => 2,
    'nav_active'     => 1
])

@section('title', 'Dashboard')

@section('content')
    <div class="bg-shell">
        <div class="container nm">
            <!-- PRODUCTS -->
            <section class="py-5">
                @if ($products->count() > 0)
                    <div class="container">
                        <div class="row justify-content-center">
                            @foreach ($products->sortBy('name') as $product)
                                <div class="col-16 col-sm-8 col-lg-5 mb-3">
                                    @include('new.components.cards.product', ['admin' => true])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection

