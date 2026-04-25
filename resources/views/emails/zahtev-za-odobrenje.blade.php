@component('mail::message')
    # Zahtev za odobrenje registracije

    Korisnik {{ $user->name }} ({{ $user->email }}) se registrovao i čeka na vaše odobrenje.

    @component('mail::button', ['url' => route('odobriRegistraciju', $user->id)])
        Odobri Registraciju
    @endcomponent

    Hvala,
    {{ config('app.name') }}
@endcomponent
