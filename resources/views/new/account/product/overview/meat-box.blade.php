<div class="row">
    <div class="col-16">
        <div class="white-box">
            <h4 class="rc d-inline-block">Meat box</h4>
            {{--<a class="btn btn-secondary float-right" href="#">Edit</a>--}}

            @include('new.components.simple-table', [
                'items'         => ['<span class="font-italic">Not yet available</span></li>' => ''],
                'table_classes' => 'mt-3',
                'bold'          => false
            ])
        </div>
    </div>
</div>