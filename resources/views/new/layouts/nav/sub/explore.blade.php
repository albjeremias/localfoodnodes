@if(isset($sub_nav) && $sub_nav == 'explore')

    <div class="bg-main-primary wc text-center text-lg-left container">
        <ul class="d-none d-md-block list-inline mb-0 sub-nav">
            <li class="list-inline-item flex-row w-25 pt-3 pt-md-0 pb-3 pb-md-4 pb-lg-1">
                <h3 class="px-md-3 wc">1129</h3>
                <small class="px-3 d-block wc">Användare</small>
            </li>

            <li class="list-inline-item flex-row w-25 pt-3 pt-md-0 pb-3 pb-md-4 pb-lg-1">
                <h3 class="px-md-3 wc">41</h3>
                <small class="px-3 d-block wc">Noder</small>
            </li>

            <li class="list-inline-item flex-row w-25 pt-3 pt-md-0 pb-3 pb-md-4 pb-lg-1">
                <h3 class="px-md-3 wc">110</h3>
                <small class="px-3 d-block wc">Producenter</small>
            </li>


            <li class="d-none d-lg-inline-block list-inline-item flex-row w-25 pt-3 pt-md-0 pb-3 pb-md-4 pb-lg-1">
                <div class="slidecontainer pl-3">
                    <input type="range" min="1" max="100" value="50" id="myRange" role="input-range">
                    <small class="d-block wc">
                        Sökradie
                        <span class="pl-3">10 km</span>
                    </small>
                </div>
            </li>

            <li class="list-inline-item flex-row w-25 pt-3 pt-md-0 pb-3 pb-md-4 pb-lg-1 float-right mr-3">
                @include('new.layouts.nav.partials.search')
            </li>
        </ul>
    </div>
@endif
{{--<script type="text/javascript" src="{{ URL::asset('js/rangeslider.js') }}"></script>--}}
