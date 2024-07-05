<div class="blok-za-nekretninu-istaknutu efekat-box-shadow">
    @if($nekretnina->istaknuta)
        <div class="istaknuto-blok">
            <span>istaknuto</span>
        </div>
    @endif
    <div class="istaknuti" role="group" aria-label="Splide Basic HTML Example">
        <div class="block-nekretnine-unutra">
            <div class="sifra-nekretnine">
                <span>ID: {{$nekretnina->sifra_nekretnine}}</span>
            </div>
            <a href="{{route("prikaziNekretninu",["id"=>$nekretnina->id])}}">
                @php
                    $slika = $nekretnina->slika;
                    list($width, $height) = getimagesize(public_path('assets/img/' . $slika->putanja));
                @endphp
                <img class="stil-za-sliku" src="{{asset('assets/img/' . $slika->putanja)}}" alt="{{$slika->alt}}" width="{{ $width }}" height="{{ $height }}">
            </a>
        </div>
    </div>
    <div class="info-block-inner tekst">
        <h2 class="bold-moj tekst-nekretnine">
            <a href="{{route("prikaziNekretninu",["id"=>$nekretnina->id])}}">{{$nekretnina->naziv}}</a>
        </h2>
        <div class="info-nekretnine-block">
            @foreach($nekretnina->a as $svojstvo)
                @if($svojstvo->atribut == 'Kvadratura' || $svojstvo->atribut == "Površina placa")
                    <div class="kvadratura-block">
                        <span>{{$svojstvo->vrednost}} m<sup>2</sup></span>
                    </div>
                @endif
            @endforeach
            <div class="cena-block">
                <span>{{number_format($nekretnina->cena, 0, ',', '.')}}&euro;@if($nekretnina->cena_metar!=null && $nekretnina->cena_metar == 1)/m<sup>2</sup>@endif</span>
            </div>
        </div>
    </div>
</div>
