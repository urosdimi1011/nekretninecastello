@extends('layouts.user')

@section('title', __('uslovi.title'))
@section('description', __('uslovi.description'))
@section('keywords', __('uslovi.keywords'))

@section('content')
    <div class="slika-pozadina">
        <div class="banner-kontakt bg-fixed">
            <div class="inner-banner-kontakt">
                <h1>{{ __('uslovi.banner') }}
                    <span class="tip-naslov tip-naslov--prazan"></span>
                </h1>
            </div>
        </div>

        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-12">
                    <div class="onama-uslovi efekat-box-shadow">
                        <div class="onama-uslovi__header">
                            <i class="ph ph-shield-check"></i>
                            <h2>{{ __('uslovi.naslov') }}</h2>
                        </div>
                        <div class="onama-uslovi__body">
                            <h3>{{ __('uslovi.uvod_naslov') }}</h3>
                            <p>{!! __('uslovi.uvod_tekst') !!}</p>

                            <h3>{{ __('uslovi.pravila_naslov') }}</h3>
                            <p>{{ __('uslovi.pravila_tekst') }}</p>

                            <h3>{{ __('uslovi.nezakonito_naslov') }}</h3>
                            <p>{{ __('uslovi.nezakonito_tekst') }}</p>

                            <h3>{{ __('uslovi.izuzece_naslov') }}</h3>
                            <p>{{ __('uslovi.izuzece_tekst') }}</p>

                            <h3>{{ __('uslovi.autorsko_naslov') }}</h3>
                            <p>{!! __('uslovi.autorsko_tekst') !!}</p>

                            <p class="mt-4"><small>{{ __('uslovi.datum') }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
