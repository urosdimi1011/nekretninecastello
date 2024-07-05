@extends('layouts.user')

@section('title', 'CASTELLO NEKRETNINE VRŠAC - 065 823 4501 Pozovite nas!')
@section('description', 'Kvalitetna ponuda kuća, stanova, lokala i placeva, pravna pomoć i savetovanje. Na jednom mestu završite sve i uselite se u vaš novi dom.')

@section('keywords', 'nekretnine,vrsac,kupi')
@section('content')
    <div class="nova-slika-kontakt">
        <div class="banner-kontakt bg-fixed">
            <div class="inner-banner-kontakt">
                <h1>Kontaktirate nas za sve informacije</h1>
            </div>
        </div>

        <div class="container mt-5 pt-5 pb-5">
            <div class="row">
                <div class="col-12 mb-5 mb-md-0 col-md-7 col-lg-7">
                    <div class="forma-blok efekat-box-shadow">
                        <form class="forma-kontakt" id="forma-kontakt">
                            <div class="informacije-header">
                                <h3><i class="fa fa-address-book"></i> Kontaktirate nas:</h3>
                            </div>
                            <div class="bottom-form-kontakt p-4">
                                <div class="form-row">
                                    <div class="form-group red-moj">
                                        <label for="imeIPrezime">Ime i prezime *</label>
                                        <input type="text" class="form-control" id="imeIPrezime" placeholder="Unesite ime i prezime">
                                        <small></small>
                                    </div>
                                    <div class="form-group red-moj">
                                        <label for="brojTelefona">Broj telefona *</label>
                                        <input type="text" class="form-control" id="brojTelefona" placeholder="Unesite broj telefona">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="text" class="form-control" id="email" placeholder="Unesite email">
                                    <p></p>
                                </div>

                                <div class="form-group postion-relative">
                                    <label for="poruka">Vaša poruka</label>
                                    <div class="postion-relative">
                                        <textarea class="form-control" id="poruka" rows="8"></textarea>
                                        <div id="brojPreostalihKaraktera" class="position-absolute">250</div>
                                    </div>
                                    <p></p>
                                </div>
                                @if(config('services.recaptcha.key'))
                                    <div class="g-recaptcha"
                                         data-sitekey="{{config('services.recaptcha.key')}}">
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-primary w-100 mt-5 color-zuta dugme-forme-kontakt">Pošalji poruku</button>
                            </div>
                        </form>
                        <p class="greska-sa-servera"></p>
                    </div>
                </div>
                <div class="col-12 col-md-5 col-lg-5">
                    <div class="kontakt-slika-block">
                        <img src="{{asset("assets/img/wallpapers/Castello-nekretnine-vrsac.jpg")}}" alt="kontakt banner slika" width="526" height="636"/>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="mapa col-12 mt-5 mb-5 mt-md-0 mb-md-0 col-md-7 col-lg-7">
                    <iframe  id="gmap_canvas" src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=en&amp;q=Sterijina%2034%20Vrsac+()&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                </div>
                <div class="col-12 col-md-5 col-lg-5">
                    <div class="informacije-blok efekat-box-shadow">
                        <div class="informacije-top">
                            <div class="informacije-header">
                                <h3><i class="fa-regular fa-map"></i> Castello nekretnine:</h3>
                            </div>
                            <ul class="info p-4">
                                <li>
                                    <strong><i class="fa-regular fa-user"></i> Igor Popović</strong>
                                    Menadžer prodaje nekretnina
                                    065/8234502
                                    castellonekretnine@gmail.com
                                </li>
                                <li>
                                    <strong><i class="fa-solid fa-location-dot"></i> Lokacija</strong>
                                    <p>Sterijina 34, <a href="https://www.google.com/maps/place/Castello+Nekretnine/@45.1205023,21.2984728,17z/data=!3m1!4b1!4m5!3m4!1s0x47501538d26b5c21:0x1c0c747d6d78321f!8m2!3d45.1205023!4d21.3006615">T.C. Bahus, lokal br. 9</a></p>
                                </li>
                                <li>
                                    <strong><i class="fa-regular fa-clock"></i> Radno vreme</strong>
                                    <p>Pon-Pet: 08-16h, Sub: 09-15h</p>
                                </li>
                            </ul>
                        </div>
                        {{--                                <div class="informacije-middle">--}}
                        {{--                                    <div class="informacije-header">--}}

                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
