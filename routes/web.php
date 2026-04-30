<?php

use App\Http\Controllers\NekeretnineController;
use App\Http\Controllers\PretplatnikController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/test-r2', function () {
    try {
        Storage::disk('r2')->put('provera.txt', 'Sajt za nekretnine radi!');

        return "Čestitam! Fajl je uspešno poslat na Cloudflare R2.";
    } catch (\Exception $e) {
        return "Greška pri povezivanju: " . $e->getMessage();
    }
});

Route::get('/login', [\App\Http\Controllers\AuthenticateUser::class, 'prikaz'])->name("login");
Route::get('/onama', [\App\Http\Controllers\OwnController::class, 'index'])->name("onama");
Route::get('/kontakt', [\App\Http\Controllers\KontaktController::class, 'index'])->name("kontakt");

Route::post('/login', [\App\Http\Controllers\AuthenticateUser::class, 'doLogin'])->name("doLogin");
//Route::post('/logout', [\App\Http\Controllers\AuthenticateUser::class, 'doLogout'])->name("doLogin");
Route::get('/register', [\App\Http\Controllers\AuthenticateUser::class, 'registracija'])->name("register");
Route::post('/register', [\App\Http\Controllers\AuthenticateUser::class, 'registracijaKorisnika'])->name("registracijaKorisnika");

Route::get('/logout', [\App\Http\Controllers\AuthenticateUser::class, 'doLogout'])->name('doLogout');
//Route::get('/odobri-registraciju/{user}', [\App\Http\Controllers\Auth\RegisterController::class, 'odobriRegistraciju'])->name('odobriRegistraciju');
//\Illuminate\Support\Facades\Auth::routes();
Route::get('/nekretnine/{identifier}', [NekeretnineController::class, 'show'])
    ->name('prikaziNekretninu');

Route::get('/admin/nekretnine/vrati/{id}', [\App\Http\Controllers\NekeretnineController::class, 'vratiNekretninu'])->name("vratiNekretninu");


Route::get('/api/tip-atributi/{id}', [\App\Http\Controllers\PretplatnikController::class, 'getAtributi']);

Route::get('/api/filteri/{tipId}', [PretplatnikController::class, 'getFilteri']);


Route::post('/pretplatnici', [\App\Http\Controllers\PretplatnikController::class, 'store'])
    // ->middleware('throttle:3,10')
    ->name('pretplatnici.store');


Route::get('/pretplatnici/verifikuj/{token}', [PretplatnikController::class, 'verifikuj'])
    ->name('pretplatnici.verifikuj');

Route::get('/pretplatnici/odjava/{token}', [PretplatnikController::class, 'odjava'])
    ->name('pretplatnici.odjava');



Route::get('/nekretnine/{tip?}/{page?}', [\App\Http\Controllers\NekeretnineController::class, 'index'])->name("nekretnineSve");

Route::get('/api/mesta', [\App\Http\Controllers\PretplatnikController::class, 'getMesta']);


Route::get('/{tip}', [\App\Http\Controllers\NekeretnineController::class, 'index'])
    ->where('tip', "kuće|kuce|stanovi|lokali|poljoprivredno_zemljište|poljoprivredno_zamljiste|poljoprivredno_zemlji%C5%A1te|placevi")
    ->name("nekretnineSvePoTipu");


Route::prefix('admin')->group(function () {
    Route::resource('/atributi', \App\Http\Controllers\AtributiController::class);
    Route::resource('/tipNekretnine', \App\Http\Controllers\TipNekretnineController::class);
    Route::resource('/tipnekretnineatributi', \App\Http\Controllers\TipNekretnineAtributiController::class);
    Route::resource('/nekretnine', \App\Http\Controllers\NekeretnineController::class);
    Route::resource('/nekretnineatributivrednost', \App\Http\Controllers\NekretnineAtributiVrednostController::class);



    //    Prikaz na admin delu

    Route::middleware(['auth.user'])->group(function () {
        Route::get('/nekretnine', [\App\Http\Controllers\NekeretnineController::class, 'prikazTabelarniNekretnine'])->name("tabelarniPrikazNekretnina");
        Route::get('/atributi', [\App\Http\Controllers\AtributiController::class, 'prikazTabelarniAtributi'])->name("tabelarniPrikazAtrbuti");
        Route::get('/tipNekretnine', [\App\Http\Controllers\TipNekretnineController::class, 'prikazTabelarniTipNekretnine'])->name("tabelarniPrikazTipNekretnine");
        Route::get('/tipnekretnineatributi', [\App\Http\Controllers\TipNekretnineAtributiController::class, 'prikazTabelarniTipNekretnineAtributa'])->name("tabelarniPrikazTipNekretnineAtributi");
        Route::get('/nekretnineatributivrednosti', [\App\Http\Controllers\NekretnineAtributiVrednostController::class, 'prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima'])->name("prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima");
    });
});


Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});
Route::post('/send-mail', [\App\Http\Controllers\KontaktController::class, 'posaljiMail'])->name("forma");
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name("home");


Route::get('/uslovi-koriscenja', function () {
    return view("pages.user.usloviKoriscenja");
})->name("uslovi");


Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/kolacici', function () {
    return view("pages.user.kolacici");
})->name("kolacici");

Route::fallback(function () {
    abort(404);
});
