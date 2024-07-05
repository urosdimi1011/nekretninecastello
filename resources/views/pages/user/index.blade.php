@extends('layouts.user')

@section('title', 'CASTELLO NEKRETNINE VRŠAC - 065 823 4501 Pozovite nas!')
@section('description', 'Kvalitetna ponuda i prodaja nekretnina od kuća, stanova, lokala i placeva, pravna pomoć i savetovanje. Na jednom mestu završite sve i uselite se u vaš novi dom na mnogobrojnim lokacijama u Vršcu. Castello nekretnine vam sve to nude, zato nemojte čekati.')

@section('keywords', 'prodaju,vršcu,stan,nekretnina,centru ')
@section('content')

    <section class="splide index-strana" aria-label="Splide Basic HTML Example">
        <div class="splide__track">
            <ul class="splide__list">
                <li class="splide__slide">
                    <div class="slide-content">
                        <img class="stil-za-sliku" width="5600" height="3200" src="{{asset("assets/img/wallpapers/modern-residential-district-with-green-roof-balcony-generated-by-ai.jpg")}}" alt="123">
                            <div class="text-overlay left">
                                <h1 class="animated-text-left">
                                    Imate nedoumice oko izbora nekretnina?
                                </h1>
                                <div class="moje-dugme-index-strana-slider">
                                    <div class="bt_bb_service_content d-flex mojee">
                                        <img src="{{asset("assets/img/icon/phone icon.png")}}" alt="phone icon">
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
                        <img class="stil-za-sliku" width="1920" height="1100" src="{{asset("assets/img/wallpapers/inner_slider_03.jpg")}}" alt="123">
                        <div class="text-overlay right">
                            <h1 class="animated-text-right">
                                Pronađite vaš novi dom
                            </h1>
                            <div class="moje-dugme-index-strana-slider">
                                <div class="bt_bb_service_content d-flex mojee">
                                    <img src="{{asset("assets/img/icon/phone icon.png")}}" alt="phone icon">
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
        <div class="splide__progress moja-klasa-za-slider"><div class="splide__progress__bar"></div></div>
    </section>

    <section class="tekst-nekretnine-block container moja-margina">
        <div class="block-tekst">
            <h2 class="mb-4">Pronađite <span>nekretninu</span> kakvu želite</h2>
            <p><strong>Kupovina ili prodaja nekretnina </strong> donosi veliko uzbuđenje, ali sa sobom nosi i veliki stres. <strong>Castello nekretnine čini tim stručnih ljudi</strong> koji su svojim znanjem i iskustvom spremni da vam sve to olakšaju.</p>
            <p><strong>Želeli smo da na jednom mestu dobijete sve</strong> – u Vršcu od kvalitetne ponude kuća, stanova, lokala i placeva, preko pravne pomoći i savetovanja, sve do <strong>useljenja u vaš novi dom.</strong>
                Bilo da kupujete nekretninu ili želite da je iznajmite, u našoj ponudi možete pronaći ono šta tražite.</p>
            <p>Ako trenutno nemamo to što vama najviše odgovara, ne brinite – <strong>pozovite nas ili popunite formular i naš agent za prodaju nekretnina će vas pozvati</strong> kako bismo što brže pronašli nekretninu kakvu ste hteli.</p>
        </div>
    </section>


    <section class="container moja-margina">

        <div class="istaktnut-naslov">
            <h2 class="text-center mb-5 mt-4 istaktnut-naslov">Istaknuti oglasi u Vršcu</h2>
        </div>
        <div class="splide splide2" role="group" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list">
                    @forelse($istaknuti as $i)

                                            <li class="splide__slide">
                                                <x-nekretnina :nekretnina="$i"/>
                                            </li>
                    @empty
                        <h4 class="ako-nema">Trenutno nema istaknutih objava</h4>
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
                        <a href="{{ route('nekretnineSvePoTipu', ['tip' => str_replace("ć","c",strtolower($tipSaDonjomCrtom))]) }}">{{ $a->tip }}</a>

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
                    <img width="705" height="705" class="full-width-image"  src="{{asset("assets/img/wallpapers/beograd-nekretnine-banner.jpg")}}" alt="Beograd nekretnine" />
                </div>
        </div>


    </section>


@endsection
