<div class="blok-za-nekretninu-istaknutu efekat-box-shadow">
    @if ($nekretnina->istaknuta)
        <div class="istaknuto-blok">
            <span>istaknuto</span>
        </div>
    @endif
    <div class="istaknuti" role="group" aria-label="Splide Basic HTML Example">
        <div class="block-nekretnine-unutra">
            <div class="sifra-nekretnine">
                <span>ID: {{ $nekretnina->sifra_nekretnine }}</span>
            </div>
            <a href="{{ route('prikaziNekretninu', ['identifier' => $nekretnina->slug ?? $nekretnina->id]) }}">
                <img class="stil-za-sliku" src="{{ asset('assets/img/' . $nekretnina->slika->putanja) }}"
                    alt="{{ $nekretnina->naziv }} Vršac" loading="lazy">
            </a>
        </div>
    </div>
    <div class="info-block-inner tekst">
        <h2 class="bold-moj tekst-nekretnine">
            <a
                href="{{ route('prikaziNekretninu', ['identifier' => $nekretnina->slug ?? $nekretnina->id]) }}">{{ $nekretnina->prevod()->naziv }}</a>
        </h2>
        @if($nekretnina->mesto)
        <div class="lokacija-block">
            <i class="ph ph-map-pin"></i>
            <span>{{ $nekretnina->mesto->naziv }}</span>
        </div>
        @endif
        <div class="info-nekretnine-block">
            @foreach ($nekretnina->a as $svojstvo)
                @php
                    $atributNaziv = is_object($svojstvo->atribut) ? $svojstvo->atribut->naziv : $svojstvo->atribut;
                @endphp
                @if ($atributNaziv == 'Kvadratura' || $atributNaziv == 'Površina placa')
                    <div class="kvadratura-block">
                        <span>{{ $svojstvo->vrednost }} m<sup>2</sup></span>
                    </div>
                    @break
                @endif
            @endforeach
            <div class="cena-block">
                @php
                    $cenaPrikaz = number_format($nekretnina->cena, 0, ',', '.') . '€';
                    if ($nekretnina->cena_metar) {
                        $cenaPrikaz .= '/m<sup>2</sup>';
                    }
                @endphp
                <span>{!! $cenaPrikaz !!}</span>
            </div>
        </div>
    </div>
</div>
