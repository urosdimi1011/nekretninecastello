@extends('layouts.user')

@section('title', 'O nama | Castello Nekretnine Vršac – Agencija za nekretnine')
@section('description', 'Castello Nekretnine Vršac – pouzdana agencija sa dugogodišnjim iskustvom. Kupovina, prodaja, pravna pomoć i savetovanje. Pozovite: 065 823 4501')
@section('keywords', 'castello nekretnine vršac, agencija za nekretnine vršac, o nama, nekretnine vršac')

@section('content')
<div class="slika-pozadina">
    <div class="banner-kontakt bg-fixed">
        <div class="inner-banner-kontakt">
            <h1>O nama
                <span class="tip-naslov tip-naslov--prazan"></span>
            </h1>
        </div>
    </div>

    <div class="container pt-5 pb-5">

        <div class="row align-items-center mb-5">
            <div class="col-12 col-md-6">
                <span class="naslov-nekretnine">Ko smo mi</span>
                <h2 class="text-naslov mt-2">Vaš pouzdani partner za nekretnine u Vršcu</h2>
                <p class="text-opis mt-3">
                    Dobrodošli u agenciju <strong>Castello Nekretnine</strong> — vašeg pouzdanog partnera u pronalaženju idealnog doma ili investicije na tržištu nekretnina u Vršcu. Naša posvećena ekipa stručnjaka ima za cilj da vam olakša put do vašeg savršenog stana, kuće ili poslovnog prostora.
                </p>
                <p class="text-opis mt-2">
                    Castello se ponosi dugogodišnjim iskustvom u posredovanju nekretninama, pružajući kvalitetne usluge klijentima svih profila — od prvih kupaca do iskusnih investitora.
                </p>
            </div>
            <div class="col-12 col-md-6 mt-4 mt-md-0">
                <div class="row row-gap">
                    <div class="col-6">
                        <div class="onama-kartica">
                            <i class="ph ph-buildings"></i>
                            <h3>Stanovi i kuće</h3>
                            <p>Široka ponuda stambenih nekretnina u Vršcu i okolini</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="onama-kartica">
                            <i class="ph ph-briefcase"></i>
                            <h3>Poslovni prostori</h3>
                            <p>Lokali i poslovni prostori za vaš biznis</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="onama-kartica">
                            <i class="ph ph-map-trifold"></i>
                            <h3>Placevi</h3>
                            <p>Građevinski i poljoprivredni placevi</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="onama-kartica">
                            <i class="ph ph-scales"></i>
                            <h3>Pravna pomoć</h3>
                            <p>Kompletna podrška u pravnoj dokumentaciji</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <div class="onama-citat efekat-box-shadow">
                    <i class="ph ph-quotes onama-citat__ikona"></i>
                    <p>Vaša budućnost je naša briga. Trudimo se da od vašeg prvog poziva do useljenja u novi dom prođe što manje vremena — uz što manje stresa.</p>
                    <span>— Tim Castello Nekretnine</span>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <div class="istaktnut-naslov mb-4">
                    <h2>Zašto izabrati <span>Castello</span>?</h2>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="onama-prednost">
                    <div class="onama-prednost__broj">01</div>
                    <h3>Iskustvo</h3>
                    <p>Dugogodišnje iskustvo na tržištu nekretnina u Vršcu i okolini garantuje vam sigurnu kupovinu.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="onama-prednost">
                    <div class="onama-prednost__broj">02</div>
                    <h3>Transparentnost</h3>
                    <p>Svaki korak procesa kupoprodaje je jasan i transparentan — bez skrivenih troškova.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="onama-prednost">
                    <div class="onama-prednost__broj">03</div>
                    <h3>Kompletna usluga</h3>
                    <p>Od pronalaska nekretnine do uknjižbe — sve na jednom mestu uz stručnu pravnu podršku.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <div class="istaktnut-naslov mb-4">
                    <h2>Kontaktirajte <span>nas</span></h2>
                </div>
                <p class="text-opis mb-4">Pozovite nas ili nam pišite — odgovorićemo u najkraćem roku.</p>
                <a href="tel:+381658234501" class="moje-dugme-index-strana-slider d-inline-block px-4 py-3 me-3">
                    <i class="ph ph-phone"></i> 065 823 4501
                </a>
                <a href="{{ route('kontakt') }}" class="btn-otkazi d-inline-block px-4 py-3">
                    Pošaljite poruku
                </a>
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
        "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "Početna",
                "item": "{{ url('/') }}"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "O nama",
                "item": "{{ url()->current() }}"
            }
        ]
    }
</script>
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AboutPage",
        "name": "O nama – Castello Nekretnine Vršac",
        "description": "Castello Nekretnine Vršac – agencija sa dugogodišnjim iskustvom u posredovanju nekretninama.",
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