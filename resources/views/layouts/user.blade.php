<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="@yield('description')"/>
    <meta name="keywords" content="@yield('keywords')">
    <meta name="theme-color" content="#31409c">
    @php
        $canonicalUrl = url()->current();
    @endphp
    <link rel="icon" href="{{asset("assets/img/icon/iconCastello.jpg")}}">
    <link rel="apple-touch-icon" href="{{asset("assets/img/icon/iconCastello.jpg")}}">

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HNWJHTB221"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-HNWJHTB221');
    </script>
    <link rel='canonical' href='{{$canonicalUrl}}' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
    />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="{{asset("assets/js/splide-4.1.3/dist/css/splide.min.css")}}">
    <link rel="stylesheet" href="{{ asset('assets/css/user.css') }}?v=1">
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="CASTELLO NEKRETNINE VRŠAC - 065 823 4501 Pozovite nas!" />
    <meta property="og:description" content="Kvalitetna ponuda kuća, stanova, lokala i placeva, pravna pomoć i savetovanje. Na jednom mestu završite sve i uselite se u vaš novi dom." />
    <meta property="og:url" content="https://probasajta.vrsacnekretnine.rs/" />
    <meta property="og:site_name" content="Vršac nekretnine" />
    <meta property="article:publisher" content="https://www.facebook.com/castello.nekretnine" />
    <meta property="article:modified_time" content="2023-05-21T19:55:36+00:00" />
    <meta name="twitter:card" content="summary_large_image" />


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>



</head>
<body>
<div class="black-wall">

</div>
<header>
    <div class="page__header__top">
        <div class="page__header__top__inner container">
            <div class="region region-top">
                <nav role="navigation">

                    <h2 class="visually-hidden block__title" id="block-topheadersociallinks-2-menu">Top Header Social Links</h2>

                    <ul class="nav nav-links">
                        <li class="nav-item">
                            <a href="tel:+381658234501" rel="noopener nofollow" class="btn btn-social link-icon label-only-size-big">
                                <i class="fa fa-phone"></i>
                                <span class="label">+381 65 8234 501</span></a></li>
                        <li class="nav-item">
                            <a href="mailto:&#099;&#097;&#115;&#116;&#101;&#108;&#108;&#111;&#110;&#101;&#107;&#114;&#101;&#116;&#110;&#105;&#110;&#101;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;" class="btn btn-social link-icon label-only-size-big text-lowercase">
                                <i class="fa fa-envelope"></i>
                                <span class="label">castellonekretnine@gmail.com</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" rel="noopener nofollow" class="btn btn-social link-icon label-only-size-big text-lowercase">
                                <i class="fa-solid fa-clock"></i>
                                <span class="label">RADNO VREME: PON-PET 08-16h SUB: 09-15h</span>
                            </a>
                        </li>
                    </ul>

                </nav>
                <nav role="navigation" aria-labelledby="block-sociallinks-menu">

                    <h2 class="visually-hidden block__title" id="block-sociallinks-menu">Social Links</h2>
                    <ul class="nav nav-links">
                        <li class="nav-item">
                            <a href="https://www.facebook.com/castello.nekretnine" target="_blank" rel="noopener nofollow" class="link-icon ext-no btn btn-social hide-label link-social">
                                <i class="fab fa-facebook"></i>
                                CASTELLO NEKRETNINE</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.instagram.com/castello_nekretnine/" target="_blank" rel="noopener nofollow" class="link-icon ext-no btn btn-social hide-label link-social">
                                <i class="fab fa-instagram"></i>
                                CASTELLO_NEKRETNINE</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.youtube.com/@castellonekretninevrsac196" target="_blank" rel="noopener nofollow" class="link-icon ext-no btn btn-social hide-label link-social">
                                <i class="fab fa-youtube"></i>
                                castellonekretninevrsac196</a>
                        </li>
                    </ul>



                </nav>
            </div>

        </div>
    </div>
    <div id="header-section" class="header-desktop header-v4 header" data-sticky="1">
        <div class="container">
            <div class="header-inner-wrap">
                <div class="navbar d-flex align-items-center p-3">



                    <div class="logo logo-desktop resposive">
                        <a href="{{route("home")}}">
                            <img src="<?=asset("assets/img/logo.png")?>" alt="logo" width="177" height="83">
                        </a>
                    </div>

                    <div class="response-button">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                    <nav class="main-nav on-hover-menu navbar-expand-lg flex-grow-1">
                        <div class="close-button">
                            <i class="fa-regular fa-circle-xmark"></i>
                        </div>
                        <ul id="main-nav" class="navbar-nav">
                            <li id="menu-item-17381" class="nav-item {{ request()->routeIs('home') ? 'current_page_item' : '' }}">
                                <a class="nav-link" href="{{ route('home') }}">Početna</a>
                            </li>
                            <li id="menu-item-17489" class="nav-item menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children dropdown {{ request()->routeIs('nekretnineSve') ? 'current-menu-item' : '' }}">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="https://www.castellonekretnine.rs/izdavanje-nekretnina/">Ponuda nekretnina</a>
                                <ul class="dropdown-menu">
                                    @foreach($tipoviNekretnina as $a)
                                            <?php
                                                $tipSaDonjomCrtom = strtolower(str_replace(' ', '_', $a->tip));
                                            ?>
                                        <li id="menu-item-17587" class="nav-item menu-item menu-item-type-post_type menu-item-object-page {{ request()->is("nekretnineSve/{$a->id}") ? 'current-menu-item' : '' }}">
                                            <a class="dropdown-item" href="{{ route('nekretnineSvePoTipu', ['tip' => str_replace("ć","c",strtolower($tipSaDonjomCrtom))]) }}">{{ $a->tip }}</a>
                                        </li>
                                    @endforeach
                                    <li id="menu-item-17587" class="nav-item menu-item menu-item-type-post_type menu-item-object-page">
                                        <a class="dropdown-item" href="https://www.castellonekretnine.rs/">Beograd</a>
                                    </li>
                                </ul>
                            </li>
                            <li id="menu-item-18177" class="nav-item menu-item menu-item-type-post_type menu-item-object-page {{ request()->is("kontakt") ? 'current-menu-item' : '' }}">
                                <a class="nav-link" href="{{ route('kontakt') }}">Kontakt</a>
                            </li>
                            <li id="menu-item-18177" class="nav-item menu-item menu-item-type-post_type menu-item-object-page">
                                <div class="logo logo-desktop">
                                    <a href="{{ route('home') }}">
                                        <img src="<?=asset("assets/img/logo.png")?>" alt="logo" width="177" height="83">
                                    </a>
                                </div>
                            </li>
                            <li id="menu-item-18144" class="nav-item menu-item menu-item-type-post_type menu-item-object-page {{ request()->routeIs('nekretnineSve') ? 'current-menu-item page_item page-item-10 current_page_item' : '' }}">
                                <a class="nav-link" href="{{ route('nekretnineSve') }}">Nekretnine</a>
                            </li>
                            <li id="menu-item-18144" class="nav-item menu-item menu-item-type-post_type menu-item-object-page {{ request()->routeIs('onama') ? 'current-menu-item page_item page-item-10 current_page_item' : '' }}">
                                <a class="nav-link" href="{{ route('onama') }}">O nama</a>
                            </li>
                            <li id="menu-item-18144" class="nav-item menu-item menu-item-type-post_type menu-item-object-page {{ request()->is('stambeni-kredit-kalkulator') ? 'current-menu-item page_item page-item-10 current_page_item' : '' }}">
                                <a class="nav-link" rel="noopener nofollow" href="https://www.castellonekretnine.rs/stambeni-kredit-kalkulator/">Kreditni Kalkulator</a>
                            </li>
                        </ul>
                        <div class="socila-menu-response">
                            <ul>
                                <li class="nav-item">
                                    <a href="https://www.facebook.com/castello.nekretnine" target="_blank" rel="noopener nofollow" class="link-icon ext-no btn btn-social hide-label link-social">
                                        <i class="fab fa-facebook"></i>
                                        CASTELLO NEKRETNINE</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.instagram.com/castello_nekretnine/" target="_blank" rel="noopener nofollow" class="link-icon ext-no btn btn-social hide-label link-social">
                                        <i class="fab fa-instagram"></i>
                                        CASTELLO_NEKRETNINE</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.youtube.com/@castellonekretninevrsac196" target="_blank" rel="noopener nofollow" class="link-icon ext-no btn btn-social hide-label link-social">
                                        <i class="fab fa-youtube"></i>
                                        castellonekretninevrsac196</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.facebook.com/castello.nekretnine" target="_blank" rel="noopener nofollow" class="link-icon ext-no btn btn-social hide-label link-social">
                                        <i class="fab fa-facebook"></i>
                                        CASTELLO NEKRETNINE</a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>



<footer>
    <div class="container-fluid">
        <div class="container">
            <div class="row pt-5 moj-flex">
                <div class="col-12 col-md-4 col-lg-3 logo-block">
                    <div class="content-block-my">
                        <div class="slika-block">
                            <img src="{{asset("assets/img/Castello-zut.png")}}" alt="logo footer" width="230" height="108">
                        </div>
                        <div class="text-logo-belowe">
                            <p>Pronađite vaš novi dom</p>
                        </div>
                        <ul class="link-icon-block p-0">
                            <li>
                                <a href="https://www.facebook.com/castello.nekretnine" rel="noopener nofollow" target="_blank">
                                    <i class="fa-brands fa-facebook"></i>
                                    <span class="hidden-link">CASTELLO NEKRETNINE</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/castello_nekretnine/" rel="noopener nofollow" target="_blank">
                                    <i class="fa-brands fa-instagram"></i>
                                    <span class="hidden-link">CASTELLO_NEKRETNINE</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/@castellonekretninevrsac196" rel="noopener nofollow" target="_blank">
                                    <i class="fa-brands fa-youtube"></i>
                                    <span class="hidden-link">castellonekretninevrsac196</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-5 col-md-5 col-lg-3">
                    <div class="header-block-content">
                        <h2>Kontakt informacije</h2>
                    </div>
                    <ul class="footer_details p-0">
                        <li><i class="fa-solid fa-location-dot"></i> <span>Sterijina 35, Vršac</span></li>
                        <li><i class="fa-solid fa-mobile"></i><span><a href="tel:065-832-4501">065-832-4501</a></span></li>
                        <li><i class="fa-regular fa-envelope"></i> <span><a href="mailto:&#099;&#097;&#115;&#116;&#101;&#108;&#108;&#111;&#110;&#101;&#107;&#114;&#101;&#116;&#110;&#105;&#110;&#101;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;"> castellonekretnine@gmail.com </a></span></li>
                        <li><i class="fa-solid fa-pencil"></i> <span><a href="#"> Broj u Reg. Posr. <strong>1228</strong> </a></span></li>
                        <li><i class="fa-solid fa-pencil"></i> <span><a href="#"> Licenca br. <strong>3499</strong> </a></span></li>

                    </ul>

                </div>
                <div class="col-5 col-md-5 col-lg-2">
                    <div class="header-block-content">
                        <h2>Nekretnine</h2>
                        <ul class="footer_details">
                            @foreach($tipoviNekretnina as $a)

                                <li  class=" link nav-item menu-item menu-item-type-post_type menu-item-object-page "><a class="dropdown-item " href="{{ route('nekretnineSvePoTipu', ['tip' => str_replace("ć","c",strtolower($a->tip))]) }}">{{$a->tip}}</a> </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
                <div class="col-5 col-md-5 col-lg-2">
                    <div class="header-block-content">
                        <h2>O nama</h2>
                        <p class="mt-4">Trudimo se da održimo visok nivo kvaliteta usluge kao i da posao završimo brzo tako da od vašeg prvog poziva do useljenja u vaš novi dom prođe što manje vremena. Svaki klijent je naš prioritet .</p>
                    </div>

                </div>
            </div>
        </div>
        <div class="container">
            <div class="row bt-color pt-2 pb-2">
                <div class="col-12 text-center">
                    <ul class="footer-link">
                        <li>
                            <small>&copy; Castello Nekretnine Vršac – Sva prava zadržana</small>
                        </li>
                        <li>
                            <a href="{{route("uslovi")}}">Uslovi korišćenja</a>
                        </li>
                        <li>
                            <a href="{{route("kolacici")}}">Kolačići</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</footer>


<script src="{{asset("assets/js/app.js")}}"></script>
<script src="{{asset("assets/js/splide-4.1.3/dist/js/splide.min.js")}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="module" src="{{asset("assets/js/main.js")}}"></script>
<script src="https://www.google.com/recaptcha/api.js" async></script>
</body>

</html>
