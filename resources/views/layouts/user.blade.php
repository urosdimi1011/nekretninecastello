<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')">
    <meta name="theme-color" content="#31409c">
    @php
        $canonicalUrl = url()->current();
        $ogLocaleMap = ['sr' => 'sr_RS', 'en' => 'en_US', 'ro' => 'ro_RO'];
        $ogLocale = $ogLocaleMap[app()->getLocale()] ?? 'sr_RS';
    @endphp
    <link rel="icon" href="{{ asset('assets/img/icon/iconCastello.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/icon/iconCastello.jpg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css">

    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $props)
        <link rel="alternate" hreflang="{{ $locale }}"
            href="{{ LaravelLocalization::getLocalizedURL($locale) }}" />
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ LaravelLocalization::getLocalizedURL('sr') }}" />

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HNWJHTB221"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-HNWJHTB221');
    </script>

    <link rel='canonical' href='{{ $canonicalUrl }}' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="{{ asset('assets/js/splide-4.1.3/dist/css/splide.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user.css') }}?v=16">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css">
    <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.js"></script>

    <meta property="og:locale" content="{{ $ogLocale }}" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="Vršac nekretnine" />
    <meta property="article:publisher" content="https://www.facebook.com/castello.nekretnine" />
    <meta property="article:modified_time" content="{{ now()->toIso8601String() }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="og:image" content="@yield('og_image', asset('assets/img/Castello-zut.png'))" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:type" content="@yield('og_type', 'website')" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="preload" as="image" href="/assets/img/wallpapers/analog-landscape-city-with-buildings.webp"
        imagesrcset="/assets/img/wallpapers/vertical-response-wallpaper.jpg 800w, /assets/img/wallpapers/analog-landscape-city-with-buildings.webp 1920w"
        imagesizes="100vw" fetchpriority="high">
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "RealEstateAgent",
            "@id": "{{ url('/') }}#agency",
            "name": "Castello Nekretnine Vršac",
            "url": "{{ url('/') }}",
            "telephone": "+381658234501",
            "email": "castellonekretnine@gmail.com",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Vaska Pope 2",
                "addressLocality": "Vršac",
                "addressCountry": "RS"
            },
            "openingHours": ["Mo-Fr 08:00-16:00", "Sa 09:00-15:00"],
            "sameAs": [
                "https://www.facebook.com/castello.nekretnine",
                "https://www.instagram.com/castello_nekretnine/"
            ]
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/umd/photoswipe.umd.min.js"></script>
</head>

<body>
    @if (session('success'))
        <div id="flashToast" class="flash-toast">
            <div class="flash-toast__content">
                <i class="fa-solid fa-circle-check flash-toast__icon"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="flash-toast__close" onclick="zatvoriFlashToast()">&times;</button>
        </div>
    @endif

    <div class="black-wall"></div>

    <header>
        <div class="page__header__top">
            <div class="page__header__top__inner container">
                <div class="region region-top">
                    <nav role="navigation">
                        <h2 class="visually-hidden block__title" id="block-topheadersociallinks-2-menu">Top Header
                            Social Links</h2>
                        <ul class="nav nav-links">
                            <li class="nav-item">
                                <a href="tel:+381658234501" rel="noopener nofollow"
                                    class="btn btn-social link-icon label-only-size-big">
                                    <i class="fa fa-phone"></i>
                                    <span class="label">+381 65 8234 501</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="mailto:&#099;&#097;&#115;&#116;&#101;&#108;&#108;&#111;&#110;&#101;&#107;&#114;&#101;&#116;&#110;&#105;&#110;&#101;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;"
                                    class="btn btn-social link-icon label-only-size-big text-lowercase">
                                    <i class="fa fa-envelope"></i>
                                    <span class="label">castellonekretnine@gmail.com</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" rel="noopener nofollow"
                                    class="btn btn-social link-icon label-only-size-big text-lowercase">
                                    <i class="fa-solid fa-clock"></i>
                                    <span class="label">{{ __('ui.radno_vreme') }}</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <nav role="navigation" aria-labelledby="block-sociallinks-menu">
                        <h2 class="visually-hidden block__title" id="block-sociallinks-menu">Social Links</h2>
                        <ul class="nav nav-links">
                            <li class="nav-item">
                                <a href="https://www.facebook.com/castello.nekretnine" target="_blank"
                                    rel="noopener nofollow"
                                    class="link-icon ext-no btn btn-social hide-label link-social">
                                    <i class="fab fa-facebook"></i> CASTELLO NEKRETNINE
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.instagram.com/castello_nekretnine/" target="_blank"
                                    rel="noopener nofollow"
                                    class="link-icon ext-no btn btn-social hide-label link-social">
                                    <i class="fab fa-instagram"></i> CASTELLO_NEKRETNINE
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.youtube.com/@castellonekretninevrsac196" target="_blank"
                                    rel="noopener nofollow"
                                    class="link-icon ext-no btn btn-social hide-label link-social">
                                    <i class="fab fa-youtube"></i> castellonekretninevrsac196
                                </a>
                            </li>
                            <li class="nav-item lang-switcher-wrap">
                                <div class="lang-switcher">
                                    @php
                                        $flagCodes = ['sr' => 'rs', 'en' => 'gb', 'ro' => 'ro'];
                                        $currentLocale = app()->getLocale();
                                    @endphp
                                    <button class="lang-switcher__btn">
                                        <span class="fi fi-{{ $flagCodes[$currentLocale] ?? 'rs' }}"></span>
                                        <span class="lang-switcher__current">{{ strtoupper($currentLocale) }}</span>
                                        <i class="fa-solid fa-chevron-down lang-switcher__arrow"></i>
                                    </button>
                                    {{-- Nevidljivi most koji sprečava gap --}}
                                    <div class="lang-switcher__bridge"></div>
                                    <ul class="lang-switcher__dropdown">
                                        @foreach (LaravelLocalization::getSupportedLocales() as $locale => $props)
                                            <li>
                                                <a href="{{ LaravelLocalization::getLocalizedURL($locale) }}"
                                                    class="{{ app()->getLocale() === $locale ? 'active' : '' }}">
                                                    <span class="fi fi-{{ $flagCodes[$locale] ?? 'rs' }}"></span>
                                                    <span class="lang-name">{{ strtoupper($locale) }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div id="header-section" class="header-desktop header-v4 header" data-sticky="1">
            <div class="container">
                <div class="header-inner-wrap">
                    <div class="navbar d-flex align-items-center p-0">
                        <div class="logo logo-desktop resposive">
                            <a href="{{ route('home') }}">
                                <img src="<?= asset('assets/img/logo.png') ?>" alt="Castello Nekretnine"
                                    width="177" height="83">
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
                                <li class="nav-item {{ request()->routeIs('home') ? 'current_page_item' : '' }}">
                                    <a class="nav-link" href="{{ route('home') }}">{{ __('ui.pocetna') }}</a>
                                </li>
                                <li class="nav-item dropdown menu-item-has-children">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                        role="button">
                                        {{ __('ui.ponuda') }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach ($tipoviNekretnina as $a)
                                            @php
                                                $slug = strtolower(str_replace(' ', '_', $a->tip));
                                                if ($slug == 'kuce') {
                                                    $slug = 'kuće';
                                                } elseif (str_contains($slug, 'poslovni')) {
                                                    $slug = 'poslovni_prostor';
                                                }

                                                $icon = 'ti ti-home';
                                                if (str_contains($slug, 'stan')) {
                                                    $icon = 'ti ti-building-community';
                                                }
                                                if (str_contains($slug, 'plac') || str_contains($slug, 'zemlj')) {
                                                    $icon = 'ti ti-map-2';
                                                }
                                                if (str_contains($slug, 'poslovni')) {
                                                    $icon = 'ti ti-briefcase';
                                                }
                                                if (str_contains($slug, 'poljoprivredno')) {
                                                    $icon = 'ti ti-tractor';
                                                }
                                                if (str_contains($slug, 'lokali')) {
                                                    $icon = 'ti ti-building-store';
                                                }
                                            @endphp
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center"
                                                    href="{{ route('nekretnineSvePoTipu', ['tip' => $slug]) }}">
                                                    <i class="{{ $icon }} me-2"
                                                        style="font-size: 1.2rem;"></i>
                                                    {{ $a->prevod()->tip }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="https://www.castellonekretnine.rs/">
                                                <i class="ti ti-map-pin me-2"></i> {{ __('ui.beograd') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ request()->is('kontakt') ? 'current-page-item' : '' }}">
                                    <a class="nav-link" href="{{ route('kontakt') }}">{{ __('ui.kontakt') }}</a>
                                </li>
                                <li class="nav-item">
                                    <div class="logo logo-desktop">
                                        <a href="{{ route('home') }}">
                                            <img src="<?= asset('assets/img/logo.png') ?>" alt="logo"
                                                width="177" height="83">
                                        </a>
                                    </div>
                                </li>
                                <li
                                    class="nav-item {{ request()->routeIs('nekretnineSve') ? 'current-menu-item page_item page-item-10 current_page_item' : '' }}">
                                    <a class="nav-link"
                                        href="{{ route('nekretnineSve') }}">{{ __('ui.nekretnine') }}</a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('onama') ? 'current_page_item' : '' }}">
                                    <a class="nav-link" href="{{ route('onama') }}">{{ __('ui.o_nama') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" rel="noopener nofollow"
                                        href="https://www.castellonekretnine.rs/stambeni-kredit-kalkulator/">{{ __('ui.kreditni_kalk') }}</a>
                                </li>
                                <li class="nav-item hidden">
                                    <div class="lang-switcher">
                                        @php
                                            $flagCodes = ['sr' => 'rs', 'en' => 'gb', 'ro' => 'ro'];
                                            $currentLocale = app()->getLocale();
                                        @endphp
                                        <button class="lang-switcher__btn">
                                            <span class="fi fi-{{ $flagCodes[$currentLocale] ?? 'rs' }}"></span>
                                            <span
                                                class="lang-switcher__current">{{ strtoupper($currentLocale) }}</span>
                                            <i class="fa-solid fa-chevron-down lang-switcher__arrow"></i>
                                        </button>
                                        <div class="lang-switcher__bridge"></div>
                                        <ul class="lang-switcher__dropdown">
                                            @foreach (LaravelLocalization::getSupportedLocales() as $locale => $props)
                                                <li>
                                                    <a href="{{ LaravelLocalization::getLocalizedURL($locale) }}"
                                                        class="{{ app()->getLocale() === $locale ? 'active' : '' }}">
                                                        <span class="fi fi-{{ $flagCodes[$locale] ?? 'rs' }}"></span>
                                                        <span class="lang-name">{{ strtoupper($locale) }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            </ul>

                            <div class="socila-menu-response">
                                <ul>
                                    <li class="nav-item">
                                        <a href="https://www.facebook.com/castello.nekretnine" target="_blank"
                                            rel="noopener nofollow"
                                            class="link-icon ext-no btn btn-social hide-label link-social">
                                            <i class="fab fa-facebook"></i> CASTELLO NEKRETNINE
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.instagram.com/castello_nekretnine/" target="_blank"
                                            rel="noopener nofollow"
                                            class="link-icon ext-no btn btn-social hide-label link-social">
                                            <i class="fab fa-instagram"></i> CASTELLO_NEKRETNINE
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.youtube.com/@castellonekretninevrsac196" target="_blank"
                                            rel="noopener nofollow"
                                            class="link-icon ext-no btn btn-social hide-label link-social">
                                            <i class="fab fa-youtube"></i> castellonekretninevrsac196
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main aria-label="{{ __('ui.glavni_sadrzaj') }}">
        @yield('content')
    </main>

    <footer>
        <div class="container-fluid">
            <div class="container">
                <div class="row pt-5 moj-flex">
                    <div class="col-12 col-md-4 col-lg-3 logo-block">
                        <div class="content-block-my">
                            <div class="slika-block">
                                <img src="{{ asset('assets/img/Castello-zut.png') }}" alt="logo footer"
                                    width="230" height="108">
                            </div>
                            <div class="text-logo-belowe">
                                <p>{{ __('ui.footer_slogan') }}</p>
                            </div>
                            <ul class="link-icon-block p-0">
                                <li>
                                    <a href="https://www.facebook.com/castello.nekretnine" rel="noopener nofollow"
                                        target="_blank">
                                        <i class="fa-brands fa-facebook"></i>
                                        <span class="hidden-link">CASTELLO NEKRETNINE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/castello_nekretnine/" rel="noopener nofollow"
                                        target="_blank">
                                        <i class="fa-brands fa-instagram"></i>
                                        <span class="hidden-link">CASTELLO_NEKRETNINE</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.youtube.com/@castellonekretninevrsac196"
                                        rel="noopener nofollow" target="_blank">
                                        <i class="fa-brands fa-youtube"></i>
                                        <span class="hidden-link">castellonekretninevrsac196</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-5 col-md-5 col-lg-3">
                        <div class="header-block-content">
                            <h2>{{ __('ui.kontakt_info') }}</h2>
                        </div>
                        <ul class="footer_details p-0">
                            <li><i class="fa-solid fa-location-dot"></i> <span>{{ __('ui.adresa') }}</span></li>
                            <li><i class="fa-solid fa-mobile"></i><span><a
                                        href="tel:065-823-4501">065-823-4501</a></span></li>
                            <li><i class="fa-regular fa-envelope"></i> <span><a
                                        href="mailto:&#099;&#097;&#115;&#116;&#101;&#108;&#108;&#111;&#110;&#101;&#107;&#114;&#101;&#116;&#110;&#105;&#110;&#101;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;">castellonekretnine@gmail.com</a></span>
                            </li>
                            <li><i class="fa-solid fa-pencil"></i> <span><a href="#"> {{ __('ui.reg_posr') }}
                                        <strong>1228</strong></a></span></li>
                            <li><i class="fa-solid fa-pencil"></i> <span><a href="#"> {{ __('ui.licenca') }}
                                        <strong>3499</strong></a></span></li>
                        </ul>
                    </div>

                    <div class="col-5 col-md-5 col-lg-2">
                        <div class="header-block-content">
                            <h2>{{ __('ui.nekretnine') }}</h2>
                            <ul class="footer_details">
                                @foreach ($tipoviNekretnina as $a)
                                    <li class="link nav-item menu-item menu-item-type-post_type menu-item-object-page">
                                        <a class="dropdown-item"
                                            href="{{ route('nekretnineSvePoTipu', ['tip' => str_replace('ć', 'c', strtolower($a->tip))]) }}">{{ $a->prevod()->tip }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-5 col-md-5 col-lg-2">
                        <div class="header-block-content">
                            <h2>{{ __('ui.o_nama') }}</h2>
                            <p class="mt-4">{{ __('ui.o_nama_tekst') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row bt-color pt-2 pb-2">
                    <div class="col-12 text-center">
                        <ul class="footer-link">
                            <li>
                                <small>
                                    {{ __('ui.sva_prava') }}
                                </small>
                            </li>
                            <li>
                                <a href="{{ route('uslovi') }}">
                                    <i class="ph ph-shield-check"></i>
                                    {{ __('ui.uslovi') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('kolacici') }}">
                                    <i class="ph ph-cookie"></i>
                                    {{ __('ui.kolacici') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ asset('assets/files/opsti-uslovi-poslovanja.pdf') }}" target="_blank"
                                    rel="noopener">
                                    <i class="ph ph-file-text"></i>
                                    {{ __('ui.uslovi_poslovanja') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <button class="notif-fab" id="openNotifModal">
        <span class="notif-fab__dot"></span>
        {{ __('ui.notif_fab') }}
    </button>

    <x-notif-modal />
    <script>
        window.AppConfig = {
            locale: '{{ app()->getLocale() }}',
            baseUrl: '{{ url('/') }}',
            routes: {
                nekretnine: '{{ route('nekretnineSve') }}',
                filteri: '{{ url('/api/filteri') }}',
                pretplatnici: '{{ route('pretplatnici.store') }}',
                sendMail: '{{ route('forma') }}',
            }
        };
    </script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async></script>
    <script src="{{ asset('assets/js/splide-4.1.3/dist/js/splide.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')

    @if (session('success'))
        <script>
            function zatvoriFlashToast() {
                const toast = document.getElementById('flashToast');
                if (!toast) return;
                toast.classList.remove('show');
            }
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.getElementById('flashToast');
                if (!toast) return;
                setTimeout(() => toast.classList.add('show'), 80);
                setTimeout(() => toast.classList.remove('show'), 5000);
            });
        </script>
    @endif

    <script>
        NProgress.configure({
            showSpinner: false,
            speed: 400,
            minimum: 0.1
        });

        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;
            const href = link.getAttribute('href');
            if (!href) return;
            if (
                href.startsWith('#') ||
                href.startsWith('javascript') ||
                href.startsWith('mailto') ||
                href.startsWith('tel') ||
                link.target === '_blank' ||
                link.hasAttribute('download') ||
                (!href.startsWith(window.AppConfig.baseUrl) && href.startsWith('http'))
            ) return;
            NProgress.start();
        });

        window.addEventListener('pageshow', function() {
            NProgress.done();
        });
    </script>
</body>

</html>
