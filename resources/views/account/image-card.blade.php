<div class="card image-card">
    <div class="card-header d-flex justify-content-between">
        <span>{{ trans('admin/image-card.image_optional') }}</span>
        <span>
            {{ $images->count() }} / {{ $limit }}
        </span>
    </div>
    <div class="card-body">
        @if ($errors->has('image'))
            <div class="mb-3">@include('account.field-error', ['field' => 'image'])</div>
        @endif

        <div class="row images">
            @foreach ($images as $index => $image)
                <div class="col-3 image">
                    <div class="image-inner">
                        <div class="action-bar">
                            <a href="{{ str_replace('{imageId}', $image->id, $deleteUrl) }}"><i class="fa fa-trash"></i></a>
                        </div>
                        <input type="hidden" name="image_sort_order[{{ $image->id }}]">
                        <img src="{{ $image->url('small') }}">
                    </div>
                </div>
            @endforeach

            @if ($images->count() < $limit)
                <script>
                    $(function() {
                        $('#image').on('change', function(event) {
                            var validMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

                            var errors = false;
                            for (var i = 0; i < this.files.length; i++) {
                                var file = this.files[i];

                                if (file.size > 10000000) {
                                    errors = true;
                                    $(document).trigger('notification', file.name + {!! json_encode(trans('admin/image-card.image_size_to_big')) !!});
                                }

                                if (validMimeTypes.indexOf(file.type) === -1) {
                                    errors = true;
                                    $(document).trigger('notification', file.name + {!! json_encode(trans('admin/image-card.image_not_valid_type')) !!});
                                }
                            }

                            if (errors === true) {
                                $('#image').val('');
                                $('#upload-image-counter').html('');
                            } else {
                                var infoText = {!! json_encode(trans('admin/image-card.images_select_for_upload')) !!};
                                var nbrOfImages = this.files.length;
                                $('#upload-image-counter').html(nbrOfImages + infoText);
                            }
                        })
                    });
                </script>
                <div class="col-3">
                    <div class="upload">
                        <b>{{ trans('admin/image-card.select_images_to_upload') }}</b>
                        <input type="file" name="image[]" id="image" multiple>
                        <div id="upload-image-counter"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Sort order -->
<script>
    jQuery(document).ready(function($) {
        $(function() {
            var setSortOrder = function(event, ui) {
                $('.images .image').each(function(index, item) {
                    $(item).find('input').val(index + '');
                });

                // Set profile image icon on first image
                $('#main-image').remove();
                $('.images .image').first().find('.action-bar').prepend('<i id="main-image" class="fa fa-picture-o" title="Main image"></i>');
            }

            $('.images').sortable({
                update: setSortOrder,
                cancel: ".upload"
            });
            $('.images').disableSelection();
            setSortOrder();
        });
    });
</script>
