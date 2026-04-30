@extends('layouts.user')

@section('title', $nekretnina->naziv.' | Castello Nekretnine Vršac')
@section('description', Str::limit(strip_tags($nekretnina->opis), 155))
@section('og_image', asset('assets/img/'.$nekretnina->slika->naziv))
@section('og_type', 'article')
@section('keywords', 'nekretnine,vršac,'.$nekretnina->tip->tip.','.strtolower($nekretnina->naziv))
@section('content')

<div class="slika-nekretnine-pozadina">
    <div class="container p-200 pb-5 naslov">

        <div class="block-nekretnine jedna-nekretnina">

            <div class="header-block-nekretnina efekat-box-shadow mt-5 pb-5">
                <div class="nekeretnina-glavna">
                    <div class="col-12 col-md-12 col-lg-6 content-block-nekretnina mb-5">
                        <div class="slider-nekretnine">
                            <section
                                class="splide nekretnina-slider h-100">
                                <div class="splide__track">
                                    <ul class="splide__list my-gallery">
                                        @foreach($nekretnina->slike as $a)

                                        <li class="splide__slide nekretnina-slika">
                                            <a data-pswp-src="{{asset("assets/img/".$a->putanja)}}">

                                                <img src="{{asset("assets/img/".$a->putanja)}}" alt="{{$a->alt}}" loading="lazy">

                                            </a>
                                        </li>

                                        @endforeach
                                    </ul>
                                </div>

                                <section class="splide thumbnail-carousel odmakni">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            @foreach($nekretnina->slike as $a)

                                            <li class="splide__slide male-slike-slider">
                                                <img src="{{asset("assets/img/".$a->putanja)}}" alt="{{$a->alt}}" loading="lazy">
                                            </li>

                                            @endforeach
                                        </ul>
                                    </div>
                                </section>

                            </section>
                            <div class="share-nekretnina mt-4">
                                <p class="mb-2"><i class="fa-solid fa-share-nodes"></i> Podeli nekretninu:</p>
                                <div class="d-flex gap-2">
                                    <a href="https://wa.me/?text={{ urlencode('Pogledajte ovu nekretninu: ' . $nekretnina->naziv . ' - ' . url()->current()) }}"
                                        target="_blank" class="btn-share btn-whatsapp" title="Podeli na WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                    <a href="viber://forward?text={{ urlencode('Pogledajte ovu nekretninu: ' . $nekretnina->naziv . ' - ' . url()->current()) }}"
                                        class="btn-share btn-viber" title="Podeli na Viber">
                                        <i class="fa-brands fa-viber"></i>
                                    </a>
                                    <a href="fb-messenger://share/?link={{ urlencode(url()->current()) }}"
                                        class="btn-share btn-messenger d-md-none" title="Podeli na Messenger">
                                        <i class="fa-brands fa-facebook-messenger"></i>
                                    </a>
                                    <button onclick="copyToClipboard()" class="btn-share btn-copy" title="Kopiraj link">
                                        <i class="fa-solid fa-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-text-video-2 mt-5">

                            <div class="text-opis mb-5">{!! $nekretnina->opis !!}</div>
                        </div>

                        <div class="dodatne-informacije bg-white efekat-box-shadow mt-5">
                            <div class="naslov-dodane-informacije mb-4">
                                <h3><i class="ph ph-info"></i> Dodatne informacije</h3>
                            </div>
                            <div class="informacije pb-4 px-4">
                                <ul class="atributi-lista p-0">
                                    @forelse($nekretnina->a as $svojstvo)
                                    <li class="atribut-kartica">
                                        <div class="atribut-ikona">
                                            <i class="{{ $svojstvo->klasaIkonice }}"></i>
                                        </div>
                                        <div class="atribut-info">
                                            <span class="atribut-naziv">{{ $svojstvo->atribut }}</span>
                                            <span class="atribut-vrednost">
                                                {{ $svojstvo->vrednost }}
                                                {!! $svojstvo->atribut == "Kvadratura" || $svojstvo->atribut == "Površina placa" ? " m<sup>2</sup>" : "" !!}
                                            </span>
                                        </div>
                                    </li>
                                    @empty
                                    <li class="empty-block">
                                        <p>Dodatne informacije nisu unete za ovu nekretninu.</p>
                                    </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        @php
                        $imaVideo = $nekretnina->video?->url ?? null;
                        $imaYoutube = $nekretnina->link_ka_videu ?? null;
                        $imaVirtualni = $nekretnina->link_ka_videu_virtual ?? null;
                        @endphp

                        @if($imaVideo || $imaYoutube || $imaVirtualni)
                        <div class="video-sekcija mt-5">

                            @if($imaVideo)
                            <div class="video-sekcija__blok">
                                <div class="video-sekcija__header">
                                    <span class="video-sekcija__ikona">
                                        <i class="ph ph-video"></i>
                                    </span>
                                    <h3>Video nekretnine</h3>
                                </div>
                                <div class="video-sekcija__player">
                                    <video controls preload="metadata" poster="">
                                        <source src="{{ $imaVideo }}" type="video/mp4">
                                        Vaš pretraživač ne podržava video.
                                    </video>
                                </div>
                            </div>
                            @endif

                            @if($imaYoutube)
                            <div class="video-sekcija__blok mt-4">
                                <div class="video-sekcija__header">
                                    <span class="video-sekcija__ikona video-sekcija__ikona--yt">
                                        <i class="ph ph-youtube-logo"></i>
                                    </span>
                                    <h3>Video prezentacija</h3>
                                </div>
                                <div class="video-sekcija__iframe-wrap">
                                    <iframe src="{{ $imaYoutube }}"
                                        title="Video prezentacija nekretnine"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                            @endif

                            @if($imaVirtualni)
                            <div class="video-sekcija__blok mt-4">
                                <div class="video-sekcija__header">
                                    <span class="video-sekcija__ikona video-sekcija__ikona--vr">
                                        <i class="ph ph-cube"></i>
                                    </span>
                                    <h3>Virtuelna tura</h3>
                                </div>
                                <div class="video-sekcija__iframe-wrap">
                                    <iframe src="{{ $imaVirtualni }}"
                                        title="Virtuelna tura nekretnine"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                            @endif

                        </div>
                        @endif
                    </div>
                    <div class="col-12 col-md-12 col-lg-5 mb-5 text-za-opis">
                        <span class="naslov-nekretnine">Castello nekretnine</span>
                        <h1 class="text-naslov">{{$nekretnina->naziv}}</h1>
                        <span class="cena"><span class="konkretna-cena">{{ number_format($nekretnina->cena, 0, ',', '.') }}</span>&euro;@if($nekretnina->cena_metar!=null && $nekretnina->cena_metar == 1)/m<sup>2</sup>@endif</span>
                        <!-- <div class="wrap-text-video">
                            <div class="text-opis mb-5">{!! $nekretnina->opis !!}</div>
                            @if( Str::wordCount(strip_tags($nekretnina->opis))<250)
                                @if($nekretnina->link_ka_videu !== null)
                                <div class="video-blok">
                                    <iframe src="{{$nekretnina->link_ka_videu}}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>

                                    </iframe>
                                </div>
                                @endif
                                @endif
                        </div> -->
                    </div>
                </div>
            </div>

        </div>


        <!-- @if(Str::wordCount(strip_tags($nekretnina->opis))>250 && $nekretnina->link_ka_videu !== null)
        <div class="video-blok veci-blok-video">
            <iframe src="{{$nekretnina->link_ka_videu}}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>

            </iframe>
        </div>
        @endif


        @if($nekretnina->link_ka_videu_virtual !== null)
        <div class="virtual-video-blok">
            <iframe src="{{$nekretnina->link_ka_videu_virtual}}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>

            </iframe>
        </div>
        @endif -->
    </div>
</div>

@endsection
@push('scripts')
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "RealEstateListing",
        "name": "{{ $nekretnina->naziv }}",
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
@endpush