@extends('layouts.user')

@section('title', __('kolacici.title'))
@section('description', __('kolacici.description'))
@section('keywords', __('kolacici.keywords'))

@section('content')
    <div class="slika-pozadina">
        <div class="banner-kontakt bg-fixed">
            <div class="inner-banner-kontakt">
                <h1>{{ __('kolacici.banner') }}
                    <span class="tip-naslov tip-naslov--prazan"></span>
                </h1>
            </div>
        </div>

        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-12">
                    <div class="onama-uslovi efekat-box-shadow">
                        <div class="onama-uslovi__header">
                            <i class="ph ph-cookie"></i>
                            <h2>{{ __('kolacici.naslov') }}</h2>
                        </div>
                        <div class="onama-uslovi__body">
                            <p>{{ __('kolacici.uvod') }}</p>

                            <h3>{{ __('kolacici.sta_je_naslov') }}</h3>
                            <p>{{ __('kolacici.sta_je_tekst') }}</p>

                            <h3>{{ __('kolacici.kako_onemoguciti_naslov') }}</h3>
                            <p>{{ __('kolacici.kako_onemoguciti_tekst') }}</p>

                            <h3>{{ __('kolacici.privremeni_naslov') }}</h3>
                            <p>{{ __('kolacici.privremeni_tekst') }}</p>

                            <h3>{{ __('kolacici.stalni_naslov') }}</h3>
                            <p>{{ __('kolacici.stalni_tekst') }}</p>

                            <h3>{{ __('kolacici.prva_strana_naslov') }}</h3>
                            <p>{{ __('kolacici.prva_strana_tekst') }}</p>

                            <h3>{{ __('kolacici.treca_strana_naslov') }}</h3>
                            <p>{{ __('kolacici.treca_strana_tekst') }}</p>

                            <h3>{{ __('kolacici.koristimo_naslov') }}</h3>
                            <p>{{ __('kolacici.koristimo_tekst') }}</p>

                            <h3>{{ __('kolacici.vrste_naslov') }}</h3>
                            <p>{{ __('kolacici.vrste_tekst') }}</p>

                            <h3>{{ __('kolacici.dodatno_naslov') }}</h3>
                            <p>{!! __('kolacici.dodatno_tekst') !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
