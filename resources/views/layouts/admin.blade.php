<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
</head>
<body class="admin-page">
<header>
    <nav class="navigation-admin">
        <div class="sidebar-top">
    <span class="shrink-btn">
        <a href="{{route("home")}}">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </span>
            <img src="{{asset("assets/img/Castello-zut.png")}}" class="logo" alt="logo">
            <h3 class="hide">Admin panel</h3>
        </div>
        <div class="group-item-admin">
            <div class="close-button">
                <i class="fa-regular fa-circle-xmark"></i>
            </div>
            <div class="sidebar-links mt-5">
                <ul>
                    <li class="tooltip-element" data-tooltip="0">
                        <a href="{{route("tabelarniPrikazNekretnina")}}" rel="noopener noreferrer" class="{{ Request::route()->getName() === 'tabelarniPrikazNekretnina' ? 'active' : '' }}" data-active="0">
                            <span class="link hide">Nekretnine</span>
                        </a>
                    </li>
                    <li class="tooltip-element" data-tooltip="1">
                        <a href="{{route("tabelarniPrikazAtrbuti")}}" rel="noopener noreferrer" class="{{ Request::route()->getName() === 'tabelarniPrikazAtrbuti' ? 'active' : '' }}" data-active="0">
                            <span class="link hide">Atrbuti</span>
                        </a>
                    </li>
                    <li class="tooltip-element" data-tooltip="2">
                        <a href="{{route("tabelarniPrikazTipNekretnine")}}" rel="noopener noreferrer" class="{{ Request::route()->getName() === 'tabelarniPrikazTipNekretnine' ? 'active' : '' }}" data-active="0">
                            <span class="link hide">Tipovi nekretnina</span>
                        </a>
                    </li>
                    <li class="tooltip-element" data-tooltip="3">
                        <a href="{{route("tabelarniPrikazTipNekretnineAtributi")}}" rel="noopener noreferrer" class="{{ Request::route()->getName() === 'tabelarniPrikazTipNekretnineAtributi' ? 'active' : '' }}" data-active="0">
                            <span class="link hide">Tipovi nekretnina i atributi</span>
                        </a>
                    </li>
                    <li class="tooltip-element" data-tooltip="3">
                        <a href="{{route("prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima")}}" rel="noopener noreferrer" class="{{ Request::route()->getName() === 'prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima' ? 'active' : '' }}" data-active="0">
                            <span class="link hide">Nekretnine i tipovi i atributi</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <a href="#" class="account tooltip-element" data-tooltip="0">
                    <i class='bx bx-user'></i>
                </a>
                <div class="admin-user tooltip-element" data-tooltip="1">
                    <div class="admin-profile hide">
                        <div class="admin-info">
                            <h3>{{session()->get("user")->name}}</h3>
                            <h5>Admin</h5>
                        </div>
                    </div>
                    <a href="{{route("doLogout")}}" class="log-out">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="response-button">
            <i class="fa-solid fa-bars"></i>
        </div>
    </nav>
</header>

<main>
    <div class="container">
        {{--    Ovo je zbog javascripta--}}
        {{--    <div class="alert"> <span class="close-alert">x</span></div>--}}
        @if(session()->get("success"))
            <div class="alert alert-success mojStil">{{session()->get("success")}} <span class="close-alert">x</span></div>
        @endif
        @if(session()->get("error"))
            <div class="alert alert-danger">{{session()->get("error")}} <span class="close-alert">x</span></div>
        @endif
        @yield('content')
    </div>
</main>

<footer>
    <!-- Zajednički deo podnožja -->

</footer>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
{{--<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/super-build/ckeditor.js"></script>--}}
<script src="{{asset("assets/js/admin.js")}}"></script>
</body>
</html>
