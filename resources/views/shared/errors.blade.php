<div class="master-alerts">
    <?php
    /*
    @if (isset($errors) && $errors->count() > 0)
        @foreach ($errors->all() as $index => $error)
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                {{ $error }}
            </div>
        @endforeach
    @endif
    */
    ?>

    @if (Session::has('message'))
        @foreach (Session::get('message') as $index => $message)
            <div class="alert alert-success" role="alert" data-dismiss="alert">
                {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endforeach
    @endif

    @if (Session::has('error'))
        @foreach (Session::get('error') as $index => $error)
            <div class="alert alert-danger" role="alert" data-dismiss="alert">
                <p>
                    {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </p>
            </div>
        @endforeach
    @endif
</div>

<script>
    $(function () {
        setTimeout(function() {
            $($('.master-alerts .alert').get().reverse()).each(function(index) {
                $(this).delay(300 * index).fadeOut();
            });
        }, 10000);
    });
</script>