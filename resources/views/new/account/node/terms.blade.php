@include('new.components.progress',
[
    'active' => 0,
    'steps'  =>
        [
            trans('admin/node.n_hdiw_item_1'),
            trans('admin/node.n_hdiw_item_2'),
            trans('admin/node.n_hdiw_item_3'),
            trans('admin/node.n_hdiw_item_4'),
        ]
])

<div class="bg-accent-light-24">
    <div class="container py-5">
        <div class="row pb-5 terms_intro">
            <div class="col-xl-8">
                {!! trans('admin/terms.new_producer_intro')  !!}
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row my-5 terms_text">
        <div class="col-md-8">
            {!! trans('admin/terms.new_producer')  !!}
        </div>
        <div class="col-md-8">
            {!! trans('admin/terms.new_producer_2')  !!}
        </div>

        <div class="col text-right my-5">
            <a class="rc text-uppercase mr-4" href="#">{{ trans('admin/terms.cancel') }}</a>
            <a class="btn btn-secondary" href="/account/producer/create?terms=approved">{{ trans('admin/terms.accept') }}</a>
        </div>
    </div>
</div>
