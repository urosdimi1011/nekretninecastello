@extends('layouts.user')

@section('title', $nekretnina->prevod()->naziv . ' | ' . __('nekretnine.castello_nekretnine'))
@section('description', Str::limit(strip_tags($nekretnina->opis), 155))
@section('og_image', asset('assets/img/' . $nekretnina->slika->naziv))
@section('og_type', 'article')
@section('keywords', 'nekretnine,vršac,' . $nekretnina->tip->tip . ',' . strtolower($nekretnina->naziv))

@section('content')
    <div class="slika-nekretnine-pozadina">
        <div class="container p-200 pb-5 naslov">

            <div class="block-nekretnine jedna-nekretnina">

                <div class="header-block-nekretnina efekat-box-shadow mt-5 pb-5">
                    <div class="nekeretnina-glavna">

                        <div class="col-12 nekretnina-naslov-blok">
                            <span class="naslov-nekretnine">{{ __('nekretnina.castello_nekretnine') }}</span>
                            <h1 class="text-naslov">{{ $nekretnina->prevod()->naziv }}</h1>
                            <p class="cena">
                                <span class="konkretna-cena">{{ number_format($nekretnina->cena, 0, ',', '.') }}</span>
                                &euro;
                                @if ($nekretnina->cena_metar != null && $nekretnina->cena_metar == 1)
                                    / m<sup>2</sup>
                                @endif
                            </p>
                        </div>

                        <section class="col-12 col-md-12 col-lg-6 content-block-nekretnina mb-5"
                            aria-label="{{ __('nekretnine.galerija_fotografija') }}">

                            <div class="slider-nekretnine">
                                <section class="splide nekretnina-slider my-gallery h-100"
                                    aria-label="{{ __('nekretnine.galerija_fotografija') }}">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            @foreach ($nekretnina->slike as $a)
                                                <li class="splide__slide nekretnina-slika" id="my-gallery">
                                                    <a target="_blank">
                                                        <img src="{{ asset('assets/img/' . $a->putanja) }}"
                                                            alt="{{ $a->alt ?? $nekretnina->prevod()->naziv . ' - ' . __('nekretnina.fotografija_nekretnine') }}" />
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </section>

                                <section class="splide thumbnail-carousel odmakni"
                                    aria-label="{{ __('nekretnina.minijature') }}">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            @foreach ($nekretnina->slike as $a)
                                                <li class="splide__slide male-slike-slider">
                                                    <img src="{{ asset('assets/img/' . $a->putanja) }}"
                                                        alt="{{ $a->alt ?? $nekretnina->prevod()->naziv }}" />
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </section>

                                <aside class="share-nekretnina mt-4" aria-label="{{ __('nekretnina.podeli_nekretninu') }}">
                                    <p class="mb-2"><i class="fa-solid fa-share-nodes" aria-hidden="true"></i>
                                        {{ __('nekretnina.podeli_nekretninu') }}:
                                    </p>
                                    <div class="d-flex gap-2">
                                        <a href="https://wa.me/?text={{ urlencode(__('nekretnina.pogledaj_nekretninu') . ': ' . $nekretnina->prevod()->naziv . ' - ' . url()->current()) }}"
                                            target="_blank" rel="noopener nofollow" class="btn-share btn-whatsapp"
                                            title="{{ __('nekretnina.podeli_na_whatsapp') }}"
                                            aria-label="{{ __('nekretnina.podeli_na_whatsapp') }}">
                                            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                                        </a>
                                        <a href="viber://forward?text={{ urlencode(__('nekretnina.pogledaj_nekretninu') . ': ' . $nekretnina->prevod()->naziv . ' - ' . url()->current()) }}"
                                            rel="noopener nofollow" class="btn-share btn-viber"
                                            title="{{ __('nekretnina.podeli_na_viber') }}"
                                            aria-label="{{ __('nekretnina.podeli_na_viber') }}">
                                            <i class="fa-brands fa-viber" aria-hidden="true"></i>
                                        </a>
                                        <a href="fb-messenger://share/?link={{ urlencode(url()->current()) }}"
                                            rel="noopener nofollow" class="btn-share btn-messenger d-md-none"
                                            title="{{ __('nekretnina.podeli_na_messenger') }}"
                                            aria-label="{{ __('nekretnina.podeli_na_messenger') }}">
                                            <i class="fa-brands fa-facebook-messenger" aria-hidden="true"></i>
                                        </a>
                                        <button onclick="copyToClipboard()" class="btn-share btn-copy"
                                            title="{{ __('nekretnina.kopiraj_link') }}"
                                            aria-label="{{ __('nekretnina.kopiraj_link') }}">
                                            <i class="fa-solid fa-link" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </aside>
                            </div>

                            {{-- Dodatne informacije --}}
                            <aside class="dodatne-informacije bg-white efekat-box-shadow mt-5"
                                aria-label="{{ __('nekretnina.dodatne_informacije') }}">
                                <div class="naslov-dodane-informacije mb-4">
                                    <h3><i class="ph ph-info" aria-hidden="true"></i>
                                        {{ __('nekretnina.dodatne_informacije') }}
                                    </h3>
                                </div>
                                <div class="informacije pb-4 px-4">
                                    <ul class="atributi-lista p-0">
                                        @forelse($nekretnina->a as $svojstvo)
                                            <li class="atribut-kartica">
                                                <div class="atribut-ikona" aria-hidden="true">
                                                    <i class="{{ $svojstvo->klasaIkonice }}"></i>
                                                </div>
                                                <div class="atribut-info">
                                                    <span
                                                        class="atribut-naziv">{{ $svojstvo->atribut->prevod()->naziv }}</span>
                                                    <span class="atribut-vrednost">
                                                        {{ $svojstvo->vrednost }}
                                                        @if (
                                                            $svojstvo->atribut->naziv == __('nekretnina.kvadratura') ||
                                                                $svojstvo->atribut->naziv == __('nekretnina.povrsina_placa'))
                                                            m<sup>2</sup>
                                                        @endif
                                                    </span>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="empty-block">
                                                <p>{{ __('nekretnina.nema_dodatnih_info') }}</p>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </aside>

                            @php
                                $imaVideo = $nekretnina->video?->url ?? null;
                                $imaYoutube = $nekretnina->link_ka_videu ?? null;
                                $imaVirtualni = $nekretnina->link_ka_videu_virtual ?? null;
                            @endphp

                            @if ($imaVideo || $imaYoutube || $imaVirtualni)
                                <section class="video-sekcija mt-5" aria-label="{{ __('nekretnina.video_nekretnine') }}">

                                    @if ($imaVideo)
                                        <div class="video-sekcija__blok">
                                            <div class="video-sekcija__header">
                                                <span class="video-sekcija__ikona" aria-hidden="true">
                                                    <i class="ph ph-video"></i>
                                                </span>
                                                <h3>{{ __('nekretnina.video_nekretnine') }}</h3>
                                            </div>
                                            <div class="video-sekcija__player">
                                                <video controls preload="metadata"
                                                    aria-label="{{ __('nekretnina.video_snimak') }} {{ $nekretnina->prevod()->naziv }}">
                                                    <source src="{{ $imaVideo }}" type="video/mp4">
                                                    {{ __('nekretnina.pretrazivac_ne_podrzava_video') }}
                                                </video>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($imaYoutube)
                                        <div class="video-sekcija__blok mt-4">
                                            <div class="video-sekcija__header">
                                                <span class="video-sekcija__ikona video-sekcija__ikona--yt"
                                                    aria-hidden="true">
                                                    <i class="ph ph-youtube-logo"></i>
                                                </span>
                                                <h3>{{ __('nekretnina.video_prezentacija') }}</h3>
                                            </div>
                                            <div class="video-sekcija__iframe-wrap">
                                                <iframe src="{{ $imaYoutube }}"
                                                    title="{{ __('nekretnina.video_prezentacija') }} {{ $nekretnina->prevod()->naziv }}"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen loading="lazy">
                                                </iframe>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($imaVirtualni)
                                        <div class="video-sekcija__blok mt-4">
                                            <div class="video-sekcija__header">
                                                <span class="video-sekcija__ikona video-sekcija__ikona--vr"
                                                    aria-hidden="true">
                                                    <i class="ph ph-cube"></i>
                                                </span>
                                                <h3>{{ __('nekretnina.virtuelna_tura') }}</h3>
                                            </div>
                                            <div class="video-sekcija__iframe-wrap">
                                                <iframe src="{{ $imaVirtualni }}"
                                                    title="{{ __('nekretnina.virtuelna_tura') }} {{ $nekretnina->prevod()->naziv }}"
                                                    allowfullscreen loading="lazy">
                                                </iframe>
                                            </div>
                                        </div>
                                    @endif

                                </section>
                            @endif

                        </section>

                        <article class="col-12 col-md-12 col-lg-5 mb-5 text-za-opis"
                            aria-label="{{ __('nekretnina.opis') }}" itemscope
                            itemtype="https://schema.org/RealEstateListing">

                            <span
                                class="naslov-nekretnine d-none d-lg-inline">{{ __('nekretnina.castello_nekretnine') }}</span>
                            <h1 class="text-naslov d-none d-lg-block" itemprop="name">
                                {{ $nekretnina->prevod()->naziv }}
                            </h1>
                            <p class="cena d-none d-lg-block">
                                <span class="konkretna-cena" itemprop="price" content="{{ $nekretnina->cena }}">
                                    {{ number_format($nekretnina->cena, 0, ',', '.') }}
                                </span>&euro;
                                <meta itemprop="priceCurrency" content="EUR">
                                @if ($nekretnina->cena_metar != null && $nekretnina->cena_metar == 1)
                                    / m<sup>2</sup>
                                @endif
                            </p>

                            <div class="text-opis mb-5" itemprop="description">
                                {!! $nekretnina->prevod()->opis !!}
                            </div>

                            @if (Str::wordCount(strip_tags($nekretnina->opis)) < 250)
                                @if ($nekretnina->link_ka_videu !== null)
                                    <div class="video-blok">
                                        <iframe src="{{ $nekretnina->link_ka_videu }}"
                                            title="{{ __('nekretnina.video_prezentacija') }} {{ $nekretnina->prevod()->naziv }}"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen loading="lazy">
                                        </iframe>
                                    </div>
                                @endif
                            @endif

                        </article>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "RealEstateListing",
        "name": "{{ $nekretnina->prevod()->naziv }}",
        "description": "{{ Str::limit(strip_tags($nekretnina->opis), 200) }}",
        "url": "{{ url()->current() }}",
        "image": "{{ asset('assets/img/'.$nekretnina->slika->naziv) }}",
        "offers": {
            "@type": "Offer",
            "price": "{{ $nekretnina->cena }}",
            "priceCurrency": "EUR"
        },
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Vršac",
            "addressCountry": "RS"
        },
        "category": "{{ $nekretnina->tip->tip }}",
        "seller": {
            "@id": "{{ url('/') }}#agency"
        }
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/umd/photoswipe-lightbox.umd.min.js"></script>

    <script>
        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href);
            alert('{{ __('nekretnine.link_kopiran') }}');
        }
    </script>
@endpush
