{{-- EXTEND NAVBAR TO SHOW ACCOUNT NAVBAR --}}
@if(isset($sub_nav) && $sub_nav == 'account')
    <div class="bg-main-primary wc text-uppercase sub-nav text-center text-lg-left">
        <ul class="list-inline mt-2 d-flex d-md-block mb-0">

            <li class="list-inline-item flex-row w-25 {{ $sub_nav_active == 0 ? 'sub-nav-active' : '' }} pb-3 pb-lg-2">
                <a class="px-md-3 wc" href="/account/user">
                    <span class="d-none d-md-inline">Dashboard</span>
                    <i class="fa fa-th-large d-md-none icon w-100"aria-hidden="true"></i>
                </a>
            </li>

            <li class="list-inline-item flex-row w-25 {{ $sub_nav_active == 1 ? 'sub-nav-active' : '' }} pb-3 pb-lg-2">
                <a class="px-md-3 wc" href="/account/nodes">
                    <span class="d-none d-md-inline">Mina noder</span>
                    <i class="fa fa-map-marker d-md-none icon w-100" aria-hidden="true"></i>
                </a>
            </li>

            <li class="list-inline-item flex-row w-25 {{ $sub_nav_active == 2 ? 'sub-nav-active' : '' }} pb-3 pb-lg-2">
                <a class="px-md-3 wc" href="#">
                    <span class="d-none d-md-inline">Utlämningar</span>
                    <i class="fa fa-home d-md-none icon w-100" aria-hidden="true"></i>
                </a>
            </li>

            <li class="list-inline-item flex-row w-25 {{ $sub_nav_active == 3 ? 'sub-nav-active' : '' }} pb-3 pb-lg-2">
                <a class="px-md-3 wc" href="#">
                    <span class="d-none d-md-inline">Evenemang</span>
                    <i class="fa fa-calendar d-md-none icon w-100" aria-hidden="true"></i>
                </a>
            </li>

            <li class="list-inline-item flex-row w-25 {{ $sub_nav_active == 4 ? 'sub-nav-active' : '' }} pb-3 pb-lg-2">
                <a class="px-md-3 wc" href="#">
                    <span class="d-none d-md-inline">Min profil</span>
                    <i class="fa fa-user d-md-none icon w-100" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
    </div>
@endif


{{-- EXTEND NAVBAR TO SHOW NODE NAVBAR --}}
@if(isset($sub_nav) && $sub_nav == 'node')
    <div class="bg-main-primary wc text-uppercase sub-nav text-center text-lg-left">
        <ul class="list-inline mt-2">
            <li class="list-inline-item">
                <a class="{{ $sub_nav_active == 0 ? 'sub-nav-active' : 'wc' }} px-3"
                   href="#">Produkter</a>
            </li>

            <li class="list-inline-item">
                <a class="{{ $sub_nav_active == 1 ? 'sub-nav-active' : 'wc' }} px-3"
                   href="#">Kalender</a>
            </li>

            <li class="list-inline-item">
                <a class="{{ $sub_nav_active == 2 ? 'sub-nav-active' : 'wc' }} px-3"
                   href="#">Producenter</a>
            </li>

            <li class="list-inline-item">
                <a class="{{ $sub_nav_active == 3 ? 'sub-nav-active' : 'wc' }} px-3"
                   href="#">Bilder</a>
            </li>
        </ul>
    </div>
@endif