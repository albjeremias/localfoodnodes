
<div class="system-messages">
    @if (Session::has('message'))
        @foreach (Session::get('message') as $index => $message)
            <div class="alert alert-success" role="alert" data-dismiss="alert">
                {{ $message }}
            </div>
        @endforeach
    @endif

    @if (Session::has('error'))
        @foreach (Session::get('error') as $index => $error)
            <div class="alert alert-danger" role="alert" data-dismiss="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
</div>

<script>
    $(function() {
        function showNotification() {
            setTimeout(function() {
                $($('.system-messages .alert').get().reverse()).each(function(index) {
                    $(this).delay(300 * index).fadeOut();
                });
            }, 5000);
        }

        showNotification();

        $(document).on('system-message', function(event, data) {
            var icon = '';
            if (data.type === 'success') {
                icon = '<i class="fa fa-check"></i>';
            } else if (data.type === 'error') {
                icon = '<i class="fas fa-exclamation-triangle"></i>';
            }

            var alert = '<div class="alert alert-type" role="alert" data-dismiss="alert">' + icon + ' ' + data.body + '</div>';

            $('.system-messages').append(alert);
            showNotification();
        });
    });
</script>
