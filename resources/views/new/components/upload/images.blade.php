<div class="dropzone" id="dropzone">
    <div class="dropzone-previews" id="dropzone-previews"></div>
</div>

@if ($images)
    @foreach ($images as $index => $image)
        <input type="hidden" name="images[]" value="{{ $image->id }}" />
    @endforeach
@endif

@if (old('images'))
    @foreach (old('images') as $index => $image)
        <input type="hidden" name="images[]" value="{{ $image->id }}" />
    @endforeach
@endif

<script src="/js/vendor/dropzone.js"></script>
<script>
    // Set url
    var uploadUrl = "{{ route('account_image_upload') }}";
    @if ($entityType && $entityId)
        uploadUrl += '?entityType={{ $entityType }}&entityId={{ $entityId }}';
    @endif

    // Create image array
    var images = [];
    @if ($images)
        @foreach ($images as $index => $image)
            images.push({
                id: '{{ $image->id }}',
                file: '{{ $image->file }}',
                url: '{{ $image->url('small') }}',
                deleteUrl: '{{ route("account_image_delete", ["imageId" => $image->id]) }}',
            });
        @endforeach
    @endif

    @if (old('images'))
        @foreach (old('images') as $index => $image)
            images.push({
                id: '{{ $image->id }}',
                file: '{{ $image->file }}',
                url: '{{ $image->url('small') }}',
                deleteUrl: '{{ route("account_image_delete", ["imageId" => $image->id]) }}',
            });
        @endforeach
    @endif

    Dropzone.autoDiscover = false;
    jQuery(document).ready(function() {
        $('#dropzone').dropzone({
            addRemoveLinks: true,
            dictCancelUpload: '',
            dictDefaultMessage: 'Drop images to upload (max {{ $limit }})',
            dictRemoveFile: 'Remove',
            maxFiles: '{{ $limit}}',
            method: 'POST',
            paramName: 'image',
            previewsContainer: '#dropzone-previews',
            uploadMultiple: true,
            url: uploadUrl,
            init: function() {
                var d = this;
                images.forEach(function(image) {
                    image.accepted = true;
                    d.files.push(image);
                    d.emit('addedfile', image);
                    d.emit('thumbnail', image, image.url);
                    d.emit('complete', image);
                });

                this.on('success', function(file, imageIds) {
                    // Loop added images and add hidden input fields with the ids
                    imageIds.forEach(function(id) {
                        var element = document.createElement('input');
                        element.setAttribute('id', id);
                        element.setAttribute('name', 'images[]');
                        element.setAttribute('type', 'hidden');
                        element.setAttribute('value', id);

                        document.getElementById('dropzone').appendChild(element);
                    });
                });

                this.on('removedfile', function(image) {
                    $.get(image.deleteUrl)
                });
            },
        });
    });
</script>
