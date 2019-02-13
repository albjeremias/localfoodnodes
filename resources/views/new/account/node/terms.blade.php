@include('new.components.progress',
[
    'active' => 0,
    'steps'  =>
        [
            __('Approve terms'),
            __('Create node'),
            __('admin/node.n_hdiw_item_3'),
            __('admin/node.n_hdiw_item_4'),
        ]
])

<div class="bg-accent-light-24">
    <div class="container py-5">
        <div class="row pb-5 terms_intro">
            <div class="col-xl-8">
                {{ __('New node info')  }}
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row my-5 terms_text">
        <div class="col-md-8">
            {{ __('New node...') }}
        </div>
        <div class="col-md-8">
            {{ trans('New node 2...')  }}
        </div>

        <div class="col text-right my-5">
            <a class="rc text-uppercase mr-4" href="#">{{ __('Cancel') }}</a>
            <a class="btn btn-secondary" href="/account/node/create?terms=approved">{{ __('Accept') }}</a>
        </div>
    </div>
</div>
