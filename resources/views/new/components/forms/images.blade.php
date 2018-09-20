<input type="file" name="image[]" id="image" class="d-none" multiple>

<div class="col-8">
    <div id="lolkek" class="bg-img-basket img-upload">
        <p class="img-title">Välj bild att ladda upp</p>
    </div>
</div>

<div class="col-8">
    <div class="bg-img-basket img-upload">
        <p class="img-title">Välj bild att ladda upp</p>
    </div>
</div>

{{--<div class="col-8 mt-2">--}}
    {{--<div class="bg-black-38 img-upload">--}}
        {{--<p class="img-title">Välj bild att ladda upp</p>--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="col-8 mt-2">--}}
    {{--<div class="bg-black-38 img-upload">--}}
        {{--<p class="img-title">Välj bild att ladda upp</p>--}}
    {{--</div>--}}
{{--</div>--}}


<script>

    var images = [];

    $('.img-upload').click(function () {
        $('#image').click();
    })

    $('#image').on('change', function(event) {
        // console.log($('#image').files().length);

        var selectedFile = event.target.files[0];


        var reader = new FileReader();

        var imgtag = $("#lolkek");
        // imgtag.title = selectedFile.name;

        reader.onload = function (event) {
            // imgtag.src = event.target.result;
            // console.log(imgtag);

            // imgtag.css('background-image', 'url(' + event.target.result + ')');

            selectedFile['src'] = event.target.result;
        };

        reader.readAsDataURL(selectedFile);

        images.push(selectedFile);

        console.log(images);

        $( ".img-upload" ).each(function( index ) {
            $(this).css('background-image', 'url(' + images[index].src + ')');
        });

    });
</script>
