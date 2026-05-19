@extends('layouts.user')

@section('title', __('onama.title'))
@section('description', __('onama.description'))
@section('keywords', __('onama.keywords'))

@section('content')
    <div class="slika-pozadina">
        <div class="banner-kontakt bg-fixed">
            <div class="inner-banner-kontakt">
                <h1>{{ __('onama.banner') }}
                    <span class="tip-naslov tip-naslov--prazan"></span>
                </h1>
            </div>
        </div>

        <div class="container pt-5 pb-5">

            <div class="row align-items-center mb-5">
                <div class="col-12 col-md-6">
                    <span class="naslov-nekretnine">{{ __('onama.ko_smo') }}</span>
                    <h2 class="text-naslov mt-2">{{ __('onama.naslov') }}</h2>
                    <p class="text-opis mt-3">{!! __('onama.opis_1') !!}</p>
                    <p class="text-opis mt-2">{{ __('onama.opis_2') }}</p>
                </div>
                <div class="col-12 col-md-6 mt-4 mt-md-0">
                    <div class="row row-gap">
                        <div class="col-6">
                            <div class="onama-kartica">
                                <i class="ph ph-buildings"></i>
                                <h3>{{ __('onama.kartica_1_naslov') }}</h3>
                                <p>{{ __('onama.kartica_1_opis') }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="onama-kartica">
                                <i class="ph ph-briefcase"></i>
                                <h3>{{ __('onama.kartica_2_naslov') }}</h3>
                                <p>{{ __('onama.kartica_2_opis') }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="onama-kartica">
                                <i class="ph ph-map-trifold"></i>
                                <h3>{{ __('onama.kartica_3_naslov') }}</h3>
                                <p>{{ __('onama.kartica_3_opis') }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="onama-kartica">
                                <i class="ph ph-scales"></i>
                                <h3>{{ __('onama.kartica_4_naslov') }}</h3>
                                <p>{{ __('onama.kartica_4_opis') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <div class="onama-citat efekat-box-shadow">
                        <i class="ph ph-quotes onama-citat__ikona"></i>
                        <p>{{ __('onama.citat') }}</p>
                        <span>{{ __('onama.citat_autor') }}</span>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <div class="istaktnut-naslov mb-4">
                        <h2>{!! __('onama.zasto_naslov') !!}</h2>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="onama-prednost">
                        <div class="onama-prednost__broj">{{ __('onama.p1_broj') }}</div>
                        <h3>{{ __('onama.p1_naslov') }}</h3>
                        <p>{{ __('onama.p1_opis') }}</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="onama-prednost">
                        <div class="onama-prednost__broj">{{ __('onama.p2_broj') }}</div>
                        <h3>{{ __('onama.p2_naslov') }}</h3>
                        <p>{{ __('onama.p2_opis') }}</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="onama-prednost">
                        <div class="onama-prednost__broj">{{ __('onama.p3_broj') }}</div>
                        <h3>{{ __('onama.p3_naslov') }}</h3>
                        <p>{{ __('onama.p3_opis') }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-center">
                    <div class="istaktnut-naslov mb-4">
                        <h2>{!! __('onama.kontakt_naslov') !!}</h2>
                    </div>
                    <p class="text-opis mb-4">{{ __('onama.kontakt_opis') }}</p>
                    <a href="tel:+381658234501" class="moje-dugme-index-strana-slider d-inline-block px-4 py-3 me-3">
                        <i class="ph ph-phone"></i> 065 823 4501
                    </a>
                    <a href="{{ route('kontakt') }}" class="btn-otkazi d-inline-block px-4 py-3">
                        {{ __('onama.kontakt_btn') }}
                    </a>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="onama-uslovi efekat-box-shadow">
                        <div class="onama-uslovi__header">
                            <i class="ph ph-file-text"></i>
                            <h2>{{ __('onama.uslovi_naslov') }}</h2>
                        </div>
                        <div class="onama-uslovi__body">
                            <p>{{ __('onama.uslovi_uvod') }}</p>
                            <div class="onama-uslovi__preuzmi">
                                <a href="{{ asset('assets/files/opsti-uslovi-poslovanja.pdf') }}" target="_blank"
                                    rel="noopener"
                                    class="moje-dugme-index-strana-slider d-inline-flex align-items-center gap-2 px-4 py-3">
                                    <i class="ph ph-arrow-square-out"></i>
                                    {{ __('onama.uslovi_preuzmi') }}
                                </a>
                            </div>
                        </div>
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
    "@type": "BreadcrumbList",
    "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "{{ __('onama.breadcrumb_pocetna') }}", "item": "{{ url('/') }}" },
        { "@type": "ListItem", "position": 2, "name": "{{ __('onama.breadcrumb_onama') }}", "item": "{{ url()->current() }}" }
    ]
}
</script>
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "AboutPage",
    "name": "{{ __('onama.schema_naziv') }}",
    "description": "{{ __('onama.schema_opis') }}",
    "url": "{{ url()->current() }}",
    "mainEntity": {
        "@type": "RealEstateAgent",
        "name": "Castello Nekretnine Vršac",
        "telephone": "+381658234501",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Vaska Pope 2",
            "addressLocality": "Vršac",
            "addressCountry": "RS"
        }
    }
}
</script>
@endpush
