@extends('layouts.user')

@section('title', 'CASTELLO NEKRETNINE VRŠAC -'.$nekretnina->naziv)
@section('description', strip_tags($nekretnina->opis))
@section('keywords', 'nekretnine,vršac,kupi,prodaju')
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

                                                <li class="splide__slide nekretnina-slika"
                                                >
                                                    <a data-pswp-src="{{asset("assets/img/".$a->putanja)}}">

                                                        <img src="{{asset("assets/img/".$a->putanja)}}" alt="{{$a->alt}}">

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
                                                        <img src="{{asset("assets/img/".$a->putanja)}}" alt="{{$a->alt}}">
                                                    </li>

                                                @endforeach
                                            </ul>
                                        </div>
                                    </section>

                                </section>
                            </div>
                            <div class="wrap-text-video-2 mt-5">
                                @if( Str::wordCount(strip_tags($nekretnina->opis))<250)
                                    @if($nekretnina->link_ka_videu !== null)
                                        <div class="video-blok">
                                            <iframe src="{{$nekretnina->link_ka_videu}}" title="YouTube video player"  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>

                                            </iframe>
                                        </div>
                                    @endif
                                @endif
                                <div class="text-opis mb-5">{!! $nekretnina->opis !!}</div>
                            </div>

                            <div class="dodatne-informacije bg-white efekat-box-shadow mt-5">
                                <div class="naslov-dodane-informacije mb-4">
                                    <h3><i class="fa-solid fa-circle-info"></i> Dodatne informacije</h3>
                                </div>
                                <div class="informacije pb-4 mt-4">
                                    <ul class="flex-list p-0">
                                        @forelse($nekretnina->a as $svojstvo)
                                            <li>
                                                <i class="{{$svojstvo->klasaIkonice}}"></i><br/> <span class="bold-moj">{{$svojstvo->atribut}}</span> <br/> {{$svojstvo->vrednost}} {!! $svojstvo->atribut == "Kvadratura" || $svojstvo->atribut == "Površina placa" ? "m"."<sup>2</sup>" : "" !!}
                                            </li>
                                        @empty
                                            <p>Nema</p>
                                        @endforelse
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5 mb-5 text-za-opis">
                            <span class="naslov-nekretnine">Castello nekretnine</span>
                            <h1 class="text-naslov">{{$nekretnina->naziv}}</h1>
                            <span class="cena"><span class="konkretna-cena">{{ number_format($nekretnina->cena, 0, ',', '.') }}</span>&euro;@if($nekretnina->cena_metar!=null && $nekretnina->cena_metar == 1)/m<sup>2</sup>@endif</span>
                            <div class="wrap-text-video">
                                <div class="text-opis mb-5">{!! $nekretnina->opis !!}</div>
                                @if( Str::wordCount(strip_tags($nekretnina->opis))<250)
                                    @if($nekretnina->link_ka_videu !== null)
                                        <div class="video-blok">
                                            <iframe src="{{$nekretnina->link_ka_videu}}" title="YouTube video player"  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>

                                            </iframe>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            @if(Str::wordCount(strip_tags($nekretnina->opis))>250 && $nekretnina->link_ka_videu !== null)
                <div class="video-blok veci-blok-video">
                    <iframe src="{{$nekretnina->link_ka_videu}}" title="YouTube video player"  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>

                    </iframe>
                </div>
            @endif


            @if($nekretnina->link_ka_videu_virtual !== null)
                <div class="virtual-video-blok">
                    <iframe src="{{$nekretnina->link_ka_videu_virtual}}" title="YouTube video player"  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>

                    </iframe>
                </div>
            @endif
        </div>
    </div>
@endsection
