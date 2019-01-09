<div class="card">
    <div class="card-header" id="heading-{{ $loop->index }}">
        <h5 class="mb-0">
            <button class="btn no-btn w-100" data-toggle="collapse" data-target="#collapse-{{ $loop->index }}" aria-expanded="true" aria-controls="collapse-{{ $loop->index }}">
                {{ $place->name }} <i class="fa fa-sort-down icon-small float-right"></i>
            </button>
        </h5>
    </div>

    <div id="collapse-{{ $loop->index }}" class="collapse" aria-labelledby="heading-{{ $loop->index }}" data-parent="#accordion">
        <div class="card-body">
            @include('new.account.product.forms.delivery-dates', [
                'dates'  => $dates,
                'place'  => $place
            ])
        </div>
    </div>
</div>