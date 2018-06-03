@include('new.components.progress',
[
    'active' => 1,
    'steps'  =>
        [
            'Läs igenom alla villkoren',
            'Skapa konto',
            'Anslut till noder',
            'Skapa produkter'
        ]
])

<div class="container my-5">

    <h2>Kontoinformation</h2>


    <div class="row mt-4">
        <div class="col-9">

            <h4>Producentinfo</h4>

            <div class="form-row mt-4">

                <div class="form-group col-8">
                    <label for="inputEmail4">Gård/Företagsnamn</label>
                    <input type="email" class="form-control-sm" id="1" placeholder="Namn">
                </div>


                <div class="form-group col-8">
                    <label for="inputPassword4">Email</label>
                    <input type="password" class="form-control-sm" id="2" placeholder="Email">
                </div>


                <div class="form-group col-8">
                    <label for="inputEmail4">Adress</label>
                    <input type="email" class="form-control-sm" id="3" placeholder="Adress">
                </div>


                <div class="form-group col-4">
                    <label for="inputPassword4">Postnummer</label>
                    <input type="password" class="form-control-sm" id="4" placeholder="Postnummer">
                </div>

                <div class="form-group col-4">
                    <label for="inputPassword4">Stad</label>
                    <input type="password" class="form-control-sm" id="5" placeholder="Stad">
                </div>

                <div class="form-group col-16">
                    <label for="inputPassword4">Beskriv din gård/ditt företag</label>
                    <textarea name="info" class="form-control wysiwyg" id="6"
                              placeholder="{{ trans('admin/producer.info') }}"
                              rows="5">{{ $producer->info or '' }}</textarea>
                </div>


                <div class="form-group col-7">

                    <h4>Betalningsinformation</h4>

                    <label for="inputPassword4">Valuta för produkter</label>
                    <select class="bb-38 form-control-sm">
                        <option value="">{{ trans('admin/producer.select_currency') }}</option>
                        @foreach (UnitsHelper::getCurrencies() as $currency)
                            <option value="{{ $currency }}" {{ $currency === $producer->currency ? 'selected' : '' }}>{{ $currency }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-16">
                    <label for="inputPassword4">Betalinformation som är inkluderat i bekräftelsen som skickas till
                        kunden</label>
                    <input type="password" class="form-control-sm" id="8" placeholder="Skriv här">
                </div>

            </div>
        </div>

        <div class="col-6 offset-1">
            <h4>Bilder</h4>

            <p>Ladda upp bilder (frivilligt)</p>
            <div class="form-row mb-5">
                @include('new.components.forms.images')
            </div>

            <h4>Länka till social media</h4>

            <div class="form-group">
                <label for="inputEmail4">Hemsida</label>
                <input type="email" class="form-control-sm" id="9" placeholder="http://">
            </div>


            <div class="form-group">
                <label for="inputPassword4">Facebook</label>
                <input type="password" class="form-control-sm" id="10" placeholder="Facebook">
            </div>

            <div class="form-group">
                <label for="inputEmail4">Twitter</label>
                <input type="email" class="form-control-sm" id="11" placeholder="Twitter">
            </div>


            <div class="form-group">
                <label for="inputPassword4">Instagram</label>
                <input type="password" class="form-control-sm" id=12" placeholder="Instagram">
            </div>

        </div>
    </div>
</div>



