@extends('layouts.user')

@section('title', __('home.title'))
@section('description', __('home.description'))
@section('keywords', __('home.keywords'))

@section('content')

<section class="splide index-strana" aria-label="{{ __('home.istaknute_aria') }}">
    <div class="splide__track">
        <ul class="splide__list">
            <li class="splide__slide">
                <div class="slide-content">
                    <img class="stil-za-sliku" width="2200" height="800"
                        src="{{ asset('assets/img/wallpapers/modern-residential-district-with-green-roof-balcony-generated-by-ai.jpg') }}"
                        alt="{{ __('home.slider_1_alt') }}">
                    <div class="text-overlay left">
                        <h1 class="animated-text-left">{{ __('home.slider_1_naslov') }}</h1>
                        <div class="moje-dugme-index-strana-slider">
                            <div class="bt_bb_service_content d-flex mojee">
                                <img src="{{ asset('assets/img/icon/phone icon.png') }}" alt="{{ __('home.telefon_alt') }}">
                                <div class="container-content">
                                    <div class="bt_bb_service_content_supertitle"><a href="tel:+381658234501">{{ __('home.pozovite') }}</a></div>
                                    <div class="bt_bb_service_content_title"><a href="tel:+381658234501">+381 65 823 4501</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="splide__slide">
                <div class="slide-content">
                    <img class="stil-za-sliku" width="2200" height="800" loading="lazy"
                        src="{{ asset('assets/img/wallpapers/inner_slider_03.jpg') }}"
                        alt="{{ __('home.slider_2_alt') }}">
                    <div class="text-overlay right">
                        <h2 class="animated-text-right">{{ __('home.slider_2_naslov') }}</h2>
                        <div class="moje-dugme-index-strana-slider">
                            <div class="bt_bb_service_content d-flex mojee">
                                <img src="{{ asset('assets/img/icon/phone icon.png') }}" alt="{{ __('home.telefon_alt') }}">
                                <div class="container-content">
                                    <div class="bt_bb_service_content_supertitle"><a href="tel:+381658234501">{{ __('home.pozovite') }}</a></div>
                                    <div class="bt_bb_service_content_title"><a href="tel:+381658234501">+381 65 823 4501</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="splide__progress moja-klasa-za-slider">
        <div class="splide__progress__bar"></div>
    </div>
</section>

<section class="tekst-nekretnine-block container moja-margina">
    <div class="row align-items-center">
        <div class="col-12 col-md-7">
            <div class="block-tekst">
                <span class="naslov-nekretnine">{{ __('home.agencija_naslov') }}</span>
                <h2 class="mb-3 mt-2">{!! __('home.agencija_h2') !!}</h2>
                <p>{!! __('home.agencija_p1') !!}</p>
                <p class="mt-3">{!! __('home.agencija_p2') !!}</p>
                <a href="{{ route('nekretnineSve') }}" class="moje-dugme-index-strana-slider d-inline-block px-4 py-3 mt-4">
                    {{ __('home.agencija_btn') }}
                </a>
            </div>
        </div>
        <div class="col-12 col-md-5 mt-4 mt-md-0">
            <div class="index-usluge">
                <div class="index-usluga">
                    <i class="ph ph-house"></i>
                    <div>
                        <h3>{{ __('home.usluga_1_naslov') }}</h3>
                        <p>{{ __('home.usluga_1_opis') }}</p>
                    </div>
                </div>
                <div class="index-usluga">
                    <i class="ph ph-buildings"></i>
                    <div>
                        <h3>{{ __('home.usluga_2_naslov') }}</h3>
                        <p>{{ __('home.usluga_2_opis') }}</p>
                    </div>
                </div>
                <div class="index-usluga">
                    <i class="ph ph-map-trifold"></i>
                    <div>
                        <h3>{{ __('home.usluga_3_naslov') }}</h3>
                        <p>{{ __('home.usluga_3_opis') }}</p>
                    </div>
                </div>
                <div class="index-usluga">
                    <i class="ph ph-scales"></i>
                    <div>
                        <h3>{{ __('home.usluga_4_naslov') }}</h3>
                        <p>{{ __('home.usluga_4_opis') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container moja-margina">
    <div class="istaktnut-naslov">
        <h2 class="text-center mb-5 mt-4">{!! __('home.istaknute_naslov') !!}</h2>
    </div>
    <div class="splide splide2" role="group" aria-label="{{ __('home.istaknute_aria') }}">
        <div class="splide__track">
            <ul class="splide__list">
                @forelse($istaknuti as $i)
                <li class="splide__slide">
                    <x-nekretnina :nekretnina="$i" />
                </li>
                @empty
                <h4 class="ako-nema">{{ __('home.istaknute_prazno') }}</h4>
                @endforelse
            </ul>
        </div>
    </div>
</section>

<section class="tipovi-nekretnina">
    <div class="container-fluid m-0 p-0 d-flex tipNekretnina-block">
        @foreach($tipoviNekretnina as $a)
        <div class="block">
            <div class="box-shadow-efekat-tip-nekretnine"></div>
            <h2 class="text-block-tip-nekretnine text-uppercase">
                @php
                    $tipSaDonjomCrtom = strtolower(str_replace(' ', '_', $a->tip));
                @endphp
                <a href="{{ route('nekretnineSvePoTipu', ['tip' => strpos($tipSaDonjomCrtom, 'ku') === 0 ? str_replace('c','ć', strtolower($tipSaDonjomCrtom)) : strtolower($tipSaDonjomCrtom)]) }}">
                    {{ $a->prevod()->tip }}
                </a>
            </h2>
            @php
                $slika = $a->slika;
                list($width, $height) = getimagesize(public_path('assets/img/' . $slika->putanja));
            @endphp
            <img class="full-width-image"
                src="{{ asset('assets/img/' . $slika->putanja) }}"
                alt="{{ $slika->alt }}"
                width="{{ $width }}"
                height="{{ $height }}" />
        </div>
        @endforeach
        <div class="block">
            <div class="box-shadow-efekat-tip-nekretnine"></div>
            <h2 class="text-block-tip-nekretnine text-uppercase">
                <a href="https://www.castellonekretnine.rs/">Beograd</a>
            </h2>
            <img width="705" height="705" class="full-width-image"
                src="{{ asset('assets/img/wallpapers/beograd-nekretnine-banner.jpg') }}"
                alt="Beograd nekretnine" />
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "@id": "{{ url('/') }}#website",
    "url": "{{ url('/') }}",
    "name": "{{ __('home.schema_naziv') }}",
    "description": "{{ __('home.schema_opis') }}",
    "publisher": { "@id": "{{ url('/') }}#agency" }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": "{{ __('home.schema_lista') }}",
    "numberOfItems": {{ count($istaknuti) }},
    "itemListElement": [
        @foreach($istaknuti as $index => $i)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "url": "{{ route('prikaziNekretninu', $i->id) }}",
            "name": {!! json_encode($i->naziv) !!}
        }{{ !$loop->last ? ',' : '' }}
        @endforeach
    ]
}
</script>
@endpush