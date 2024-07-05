@extends('layouts.user')

@section('title', 'CASTELLO NEKRETNINE VRŠAC - 065 823 4501 Pozovite nas!')
@section('description', 'Kvalitetna ponuda kuća, stanova, lokala i placeva, pravna pomoć i savetovanje. Na jednom mestu završite sve i uselite se u vaš novi dom.')
@if(request("tip") !== null)
    @section('keywords', 'prodaju,nekretnine,vršac,'.request("tip").',castello')
        @else
    @section('keywords', 'prodaju,nekretnine,vršac,kuća,castello')
        @endif
@section('content')
    <div class="slika-pozadina">
        <div class="banner-kontakt bg-fixed">
            <div class="inner-banner-kontakt">
                <h1>Nekretnine Vršac
                    @if(request("tip") !== null)
                        @foreach($tipoviNekretnina as $n)
                            @php
                                $tipSaDonjomCrtom = strtolower(str_replace('_', ' ', request("tip")));
                            @endphp
                            @if(strtolower(strpos($tipSaDonjomCrtom, 'ku') === 0 ? str_replace("c","ć",$tipSaDonjomCrtom) : $tipSaDonjomCrtom) == strtolower($n->tip))
                                <span class="tip-naslov">({{$n->tip}})</span>
                            @endif
                        @endforeach
                    @elseif(isset($tip) && $tip != null)
                        <span class="tip-naslov">({{ucfirst($tipSaDonjomCrtom)}})</span>
                    @else
                        <span class="tip-naslov">(Sve)</span>
                    @endif
                </h1>
            </div>
        </div>

        <div class="container pt-5">
            <div class="row">
                <div class="col-6 col-md-6 col-lg-5 aling-end">
                    <div class="rezulati">
                        <p><span class="rez">{{$nekretnine->total()}}</span> Rezultata</p>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7 d-flex">
                    <div class="row">
                        <form class="col-12 col-md-6 col-lg-6 text-right filter">

                            <label>Tipovi nekretnine</label>
                            <select class="custom-select sources tipNekretnine-select"
                                    placeholder="Izaberite tip nekretnine">
                                <option value="">Početni filter</option>
                                @foreach($tipoviNekretnina as $n)
                                    @if($n->tip == "Beograd") @break @endif
                                    <option @if(request("tip") == $n->id || ucfirst(request("tip")) == $n->tip) selected="true"
                                            @endif value="{{$n->id}}">{{$n->tip}}</option>
                                @endforeach
                            </select>
                        </form>

                        <form class="col-12 col-md-6 col-lg-6 text-right filter">
                            <label>Sortiraj nekretnine</label>
                            <select class="custom-select sources" placeholder="Izaberite način filtriranja">
                                <option value="">Početni filter</option>
                                <option value="cena-asc">Ceni - Manja ka većoj</option>
                                <option value="cena-desc">Ceni - Većoj ka manjoj</option>
                                <option value="created_at-asc">Datum - stariji ka novijem</option>
                                <option value="created_at-desc">Datum - noviji ka starijem</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5 nekretnine-sve">
            <div class="row row-gap nekretnine-sve-js">
                @forelse($nekretnine as $n)

                    <div class="col-12 col-md-6 col-lg-4">
                        <x-nekretnina :nekretnina="$n"/>
                    </div>

                @empty
                    <div class="col-12 text-center ako-nema-nekretnina-poruka">
                        <p>Trenutno nema nekretnina za zadati kriterijum filtriranja</p>
                    </div>
                @endforelse

                <div class="mt-5 pag justify-content-center">
                    {{$nekretnine->withQueryString()->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
@endsection
