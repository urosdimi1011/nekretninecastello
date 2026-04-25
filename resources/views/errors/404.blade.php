@extends('layouts.user')

@section('title', 'Page not found - Castello nekretnine Vršac')
@section('description', 'Kvalitetna ponuda kuća, stanova, lokala i placeva, pravna pomoć i savetovanje. Na jednom mestu završite sve i uselite se u vaš novi dom.')

@section('keywords', 'greska,404,pogresno')
@section('content')

    <div class="container p-200 text-center ">
        <div class="row">
            <h1 class="poruka-greska-404">Traženu stranicu ne možemo da pronađemo.</h1>
            <h2 class="poruka-greska-404">Idite na <a href="{{route("home")}}">početnu stranicu</a></h2>
            <h2 class="g404-greska p-5">404</h2>
        </div>
    </div>

@endsection
