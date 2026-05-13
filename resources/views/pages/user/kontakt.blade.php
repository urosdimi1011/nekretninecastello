@extends('layouts.user')

@section('title', __('kontakt.title'))
@section('description', __('kontakt.description'))
@section('keywords', __('kontakt.keywords'))

@section('content')
<div class="nova-slika-kontakt">
    <div class="banner-kontakt bg-fixed">
        <div class="inner-banner-kontakt">
            <h1>{{ __('kontakt.banner') }}
                <span class="tip-naslov tip-naslov--prazan"></span>
            </h1>
        </div>
    </div>

    <div class="container mt-5 pt-3 pb-5">

        <div class="row mb-4" style="row-gap: 24px;">
            <div class="col-12 col-md-7">
                <div class="kontakt-forma-blok">
                    <div class="kontakt-forma-header">
                        <i class="fa-regular fa-envelope"></i>
                        {{ __('kontakt.forma_naslov') }}
                    </div>
                    <div class="kontakt-forma-body">
                        <form id="forma-kontakt">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="imeIPrezime">{{ __('kontakt.ime') }}</label>
                                    <input type="text" id="imeIPrezime"
                                        placeholder="{{ __('kontakt.ime_ph') }}">
                                    <small></small>
                                </div>
                                <div class="form-group">
                                    <label for="brojTelefona">{{ __('kontakt.telefon') }}</label>
                                    <input type="text" id="brojTelefona"
                                        placeholder="{{ __('kontakt.telefon_ph') }}">
                                    <p></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('kontakt.email') }}</label>
                                <input type="text" id="email"
                                    placeholder="{{ __('kontakt.email_ph') }}">
                                <p></p>
                            </div>

                            <div class="form-group" style="position:relative">
                                <label for="poruka">{{ __('kontakt.poruka') }}</label>
                                <div style="position:relative">
                                    <textarea id="poruka" rows="6"></textarea>
                                    <div id="brojPreostalihKaraktera"
                                        style="position:absolute;bottom:10px;right:10px;font-size:12px;color:#aaa">
                                        250
                                    </div>
                                </div>
                                <p></p>
                            </div>

                            @if(config('services.recaptcha.key'))
                            <div class="g-recaptcha mb-3"
                                data-sitekey="{{ config('services.recaptcha.key') }}">
                            </div>
                            @endif

                            <button type="submit" class="kontakt-submit dugme-forme-kontakt">
                                {{ __('kontakt.posalji') }}
                            </button>
                        </form>
                        <p class="greska-sa-servera mt-2" style="color:#dc3545;font-size:13px"></p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-5">
                <div class="kontakt-slika-block" style="height:100%;min-height:300px">
                    <img src="{{ asset('assets/img/wallpapers/Castello-nekretnine-vrsac.jpg') }}"
                        alt="Castello Nekretnine Vršac kancelarija"
                        width="526" height="636" />
                </div>
            </div>
        </div>

        <div class="row" style="row-gap: 24px;">
            <div class="col-12 col-md-7">
                <div class="kontakt-mapa-wrap">
                    <iframe id="gmap_canvas"
                        src="https://maps.google.com/maps?width=520&height=400&hl=en&q=Sterijina%2034%20Vrsac+()&t=&z=12&ie=UTF8&iwloc=B&output=embed"
                        loading="lazy">
                    </iframe>
                </div>
            </div>

            <div class="col-12 col-md-5">
                <div class="kontakt-info-blok">
                    <div class="kontakt-info-header">
                        <i class="fa-regular fa-map"></i>
                        {{ __('kontakt.info_naslov') }}
                    </div>
                    <ul class="kontakt-info-lista">
                        <li class="kontakt-info-item">
                            <div class="kontakt-info-ikona">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <div class="kontakt-info-tekst">
                                <strong>Igor Popović</strong>
                                <span>{{ __('kontakt.menadzer') }}</span>
                                <a href="tel:0658234501">065/823-4501</a>
                                <a href="mailto:castellonekretnine@gmail.com">castellonekretnine@gmail.com</a>
                            </div>
                        </li>
                        <li class="kontakt-info-item">
                            <div class="kontakt-info-ikona">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="kontakt-info-tekst">
                                <strong>{{ __('kontakt.lokacija') }}</strong>
                                <span>{{ __('kontakt.adresa') }}</span>
                            </div>
                        </li>
                        <li class="kontakt-info-item">
                            <div class="kontakt-info-ikona">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div class="kontakt-info-tekst">
                                <strong>{{ __('kontakt.radno_vreme') }}</strong>
                                <span>{{ __('kontakt.radno') }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
{{-- FALI SCRIPTA ZA SEO! --}}