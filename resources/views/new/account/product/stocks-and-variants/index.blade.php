@extends('new.account.layout',
[
    'nav_title'      => trans('admin/user.nav_title'),
    'sub_nav'        => 'producer',
    'sub_nav_active' => 2,
    'nav_active'     => 1
])

@section('title', 'Dashboard')
@section('content')
    <div class="nm bg-shell">
        <div class="container pt-2">
            <div class="white-box">
                <h5 class="rc mb-4">{{ __('Stock') }}</h5>
                <form>
                    @include('new.account.product.forms.stock')
                    @include('new.components.forms.submit')
                </form>
            </div>

            <div class="white-box">
                <h5 class="rc mb-4">{{ __('Variants') }}</h5>
                @include('new.account.product.forms.variants-settings')

                @if(count($product->productVariants()) > 0)
                    @include('new.account.product.forms.variants')
                @else
                    <p>{{ __('No variants') }}</p>
                    @include('new.account.product.forms.new-variant')
                @endif
                @include('new.components.forms.submit')
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#checkbox-variants').change(function () {
                $('#checkbox-shared-stock').prop('disabled', function(i, v) { return !v; });
                $('#dropdown-product_content_specified').prop('disabled', function(i, v) { return !v; });
            });
        });
    </script>
@endsection



