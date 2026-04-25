@extends('layouts.user')

@section('title', 'Castello Nekretnine Vršac | Kuće, Stanovi, Placevi i Zemljišta')
@section('description', 'Nekretnine Vršac – Castello nekretnine nude prodaju kuća, stanova, lokala, placeva i poljoprivrednih zemljišta. Pravna pomoć i savetovanje. Pozovite: 065 823 4501')
@section('keywords', 'nekretnine vrsac, vrsac nekretnine, prodaja nekretnina vrsac, kuce vrsac, stanovi vrsac, lokali vrsac, placevi vrsac, poljoprivredno zemljiste vrsac, castello nekretnine, agencija za nekretnine vrsac')
@section('content')

<section class="splide index-strana" aria-label="Nekretnine Vršac – Castello Nekretnine slider">
    <div class="splide__track">
        <ul class="splide__list">
            <li class="splide__slide">
                <div class="slide-content">
                    <img class="stil-za-sliku" width="2200" height="800" src="{{asset("assets/img/wallpapers/modern-residential-district-with-green-roof-balcony-generated-by-ai.jpg")}}" alt="Nekretnine Vršac - Castello nekretnine">
                    <div class="text-overlay left">
                        <h1 class="animated-text-left">
                            Nekretnine Vršac – pronađite vaš novi dom
                        </h1>
                        <div class="moje-dugme-index-strana-slider">
                            <div class="bt_bb_service_content d-flex mojee">
                                <img src="{{asset("assets/img/icon/phone icon.png")}}" alt="Pozovite Castello nekretnine">
                                <div class="container-content">
                                    <div class="bt_bb_service_content_supertitle">POZOVITE ODMAH</div>
                                    <div class="bt_bb_service_content_title">+381 65 823 4501</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li class="splide__slide">
                <div class="slide-content">
                    <img class="stil-za-sliku" width="2200" height="800" loading="lazy" src="{{asset("assets/img/wallpapers/inner_slider_03.jpg")}}" alt="Prodaja kuća i stanova u Vršcu">
                    <div class="text-overlay right">
                        <h2 class="animated-text-right">
                            Prodaja kuća, stanova i placeva u Vršcu
                        </h2>
                        <div class="moje-dugme-index-strana-slider">
                            <div class="bt_bb_service_content d-flex mojee">
                                <img src="{{asset("assets/img/icon/phone icon.png")}}" alt="Pozovite Castello nekretnine">
                                <div class="container-content">
                                    <div class="bt_bb_service_content_supertitle">POZOVITE ODMAH</div>
                                    <div class="bt_bb_service_content_title">+381 65 823 4501</div>
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
                <span class="naslov-nekretnine">Agencija za nekretnine Vršac</span>
                <h2 class="mb-3 mt-2">Pronađite <span>nekretninu u Vršcu</span> kakvu želite</h2>
                <p><strong>Kupovina ili prodaja nekretnina</strong> donosi veliko uzbuđenje, ali sa sobom nosi i veliki stres. <strong>Castello nekretnine čini tim stručnih ljudi</strong> koji su svojim znanjem i iskustvom spremni da vam sve to olakšaju.</p>
                <p class="mt-3"><strong>Želeli smo da na jednom mestu dobijete sve</strong> – od kvalitetne ponude kuća, stanova, lokala i placeva, preko pravne pomoći i savetovanja, sve do <strong>useljenja u vaš novi dom.</strong></p>
                <a href="{{ route('nekretnineSve') }}" class="moje-dugme-index-strana-slider d-inline-block px-4 py-3 mt-4">
                    Pogledajte sve nekretnine
                </a>
            </div>
        </div>
        <div class="col-12 col-md-5 mt-4 mt-md-0">
            <div class="index-usluge">
                <div class="index-usluga">
                    <i class="ph ph-house"></i>
                    <div>
                        <h3>Stanovi i kuće</h3>
                        <p>Široka ponuda stambenih nekretnina</p>
                    </div>
                </div>
                <div class="index-usluga">
                    <i class="ph ph-buildings"></i>
                    <div>
                        <h3>Poslovni prostori</h3>
                        <p>Lokali i poslovni prostori za vaš biznis</p>
                    </div>
                </div>
                <div class="index-usluga">
                    <i class="ph ph-map-trifold"></i>
                    <div>
                        <h3>Placevi i zemljišta</h3>
                        <p>Građevinski i poljoprivredni placevi</p>
                    </div>
                </div>
                <div class="index-usluga">
                    <i class="ph ph-scales"></i>
                    <div>
                        <h3>Pravna pomoć</h3>
                        <p>Kompletna podrška u dokumentaciji</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="container moja-margina">

    <div class="istaktnut-naslov">
        <h2 class="text-center mb-5 mt-4 istaktnut-naslov">Istaknute nekretnine u <span>Vršcu</span></h2>
    </div>
    <div class="splide splide2" role="group" aria-label="Istaknute nekretnine u Vršcu">
        <div class="splide__track">
            <ul class="splide__list">
                @forelse($istaknuti as $i)

                <li class="splide__slide">
                    <x-nekretnina :nekretnina="$i" />
                </li>
                @empty
                <h4 class="ako-nema">Trenutno nema istaknutih nekretnina</h4>
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
                <?php
                $tipSaDonjomCrtom = strtolower(str_replace(' ', '_', $a->tip));
                ?>
                <a href="{{ route('nekretnineSvePoTipu', ['tip' => strpos($tipSaDonjomCrtom, 'ku') === 0 ? str_replace("c","ć",strtolower($tipSaDonjomCrtom)) : strtolower($tipSaDonjomCrtom)]) }}">{{ $a->tip }}</a>

            </h2>
            @php
            $slika = $a->slika;
            list($width, $height) = getimagesize(public_path('assets/img/' . $slika->putanja));
            @endphp
            <img class="full-width-image" src="{{ asset('assets/img/' . $slika->putanja) }}" alt="{{ $slika->alt }}" width="{{ $width }}" height="{{ $height }}" />
        </div>
        @endforeach
        <div class="block">
            <div class="box-shadow-efekat-tip-nekretnine"></div>
            <h2 class="text-block-tip-nekretnine text-uppercase"><a href="https://www.castellonekretnine.rs/">Beograd</a></h2>
            <img width="705" height="705" class="full-width-image" src="{{asset("assets/img/wallpapers/beograd-nekretnine-banner.jpg")}}" alt="Beograd nekretnine" />
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
        "name": "Castello Nekretnine Vršac",
        "description": "Agencija za nekretnine u Vršcu – prodaja kuća, stanova, lokala i placeva",
        "publisher": {
            "@id": "{{ url('/') }}#agency"
        }
    }
</script>
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "Istaknute nekretnine u Vršcu – Castello Nekretnine",
        "numberOfItems": {
            {
                count($istaknuti)
            }
        },
        "itemListElement": [
            @foreach($istaknuti as $index => $i) {
                "@type": "ListItem",
                "position": {
                    {
                        $index + 1
                    }
                },
                "url": "{{ route('prikaziNekretninu', $i->id) }}",
                "name": {
                    !!json_encode($i - > naziv) !!
                }
            } {
                {
                    !$loop - > last ? ',' : ''
                }
            }
            @endforeach
        ]
    }
</script>
@endpush