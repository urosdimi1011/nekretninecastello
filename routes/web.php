<?php

use App\Http\Controllers\MestaController;
use App\Http\Controllers\NekeretnineController;
use App\Http\Controllers\PretplatnikController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/login', [\App\Http\Controllers\AuthenticateUser::class, 'prikaz'])->name("login");
Route::post('/login', [\App\Http\Controllers\AuthenticateUser::class, 'doLogin'])->name("doLogin");
Route::get('/register', [\App\Http\Controllers\AuthenticateUser::class, 'registracija'])->name("register");
Route::post('/register', [\App\Http\Controllers\AuthenticateUser::class, 'registracijaKorisnika'])->name("registracijaKorisnika");
Route::get('/logout', [\App\Http\Controllers\AuthenticateUser::class, 'doLogout'])->name('doLogout');

Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::get('/api/tip-atributi/{id}', [\App\Http\Controllers\PretplatnikController::class, 'getAtributi']);
Route::get('/api/filteri/{tipId}', [PretplatnikController::class, 'getFilteri']);
Route::get('/api/mesta', [\App\Http\Controllers\PretplatnikController::class, 'getMesta']);

Route::post('/pretplatnici', [\App\Http\Controllers\PretplatnikController::class, 'store'])
    ->middleware('throttle:3,10')
    ->name('pretplatnici.store');
Route::get('/pretplatnici/verifikuj/{token}', [PretplatnikController::class, 'verifikuj'])->name('pretplatnici.verifikuj');
Route::get('/pretplatnici/odjava/{token}', [PretplatnikController::class, 'odjava'])->name('pretplatnici.odjava');

Route::get('/phpinfo', function () {
    phpinfo();
});


Route::prefix('admin')->group(function () {



    Route::resource('/atributi', \App\Http\Controllers\AtributiController::class);
    Route::resource('/tipNekretnine', \App\Http\Controllers\TipNekretnineController::class);
    Route::resource('/tipnekretnineatributi', \App\Http\Controllers\TipNekretnineAtributiController::class);
    Route::resource('/nekretnine', \App\Http\Controllers\NekeretnineController::class);
    Route::resource('/nekretnineatributivrednost', \App\Http\Controllers\NekretnineAtributiVrednostController::class);
    Route::get('/nekretnine/vrati/{id}', [\App\Http\Controllers\NekeretnineController::class, 'vratiNekretninu'])->name("vratiNekretninu");

    Route::middleware(['auth.user'])->group(function () {
        Route::patch('/mesta/{id}', [MestaController::class, 'update'])
            ->name('mesta.update');
        Route::get('/mesta', [MestaController::class, 'index'])
            ->name('tabelarniPrikazMesta');
        Route::get('/mesta/create', [MestaController::class, 'create'])
            ->name('formaZaDodavanjeMesta');
        Route::post('/mesta', [MestaController::class, 'store'])
            ->name('mesta.store');
        Route::get('/mesta/{id}/edit', [MestaController::class, 'edit'])
            ->name('formaZaIzmenuMesta');
        Route::delete('/mesta/{id}', [MestaController::class, 'destroy'])
            ->name('mesta.delete');
        Route::get('/pretplatnici', [PretplatnikController::class, 'index'])
            ->name('tabelarniPrikazPretplatnika');
        Route::delete('/pretplatnici/{id}', [PretplatnikController::class, 'destroy'])
            ->name('obrisiPretplatnika');

        Route::get('/nekretnine', [\App\Http\Controllers\NekeretnineController::class, 'prikazTabelarniNekretnine'])->name("tabelarniPrikazNekretnina");
        Route::get('/atributi', [\App\Http\Controllers\AtributiController::class, 'prikazTabelarniAtributi'])->name("tabelarniPrikazAtrbuti");
        Route::get('/tipNekretnine', [\App\Http\Controllers\TipNekretnineController::class, 'prikazTabelarniTipNekretnine'])->name("tabelarniPrikazTipNekretnine");
        Route::get('/tipnekretnineatributi', [\App\Http\Controllers\TipNekretnineAtributiController::class, 'prikazTabelarniTipNekretnineAtributa'])->name("tabelarniPrikazTipNekretnineAtributi");
        Route::get('/nekretnineatributivrednosti', [\App\Http\Controllers\NekretnineAtributiVrednostController::class, 'prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima'])->name("prikazTabelarniNekretnineITipoveSaKonkretnimVrednostima");
    });
});


Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localizationRedirect'],
], function () {

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name("home");

    Route::get('/onama', [\App\Http\Controllers\OwnController::class, 'index'])->name("onama");
    Route::get('/kontakt', [\App\Http\Controllers\KontaktController::class, 'index'])->name("kontakt");
    Route::post('/send-mail', [\App\Http\Controllers\KontaktController::class, 'posaljiMail'])->name("forma");

    Route::get('/uslovi-koriscenja', function () {
        return view("pages.user.usloviKoriscenja");
    })->name("uslovi");

    Route::get('/kolacici', function () {
        return view("pages.user.kolacici");
    })->name("kolacici");

    Route::get('/nekretnine/{identifier}', [NekeretnineController::class, 'show'])
        ->name('prikaziNekretninu');

    Route::get('/nekretnine/{tip?}/{page?}', [NekeretnineController::class, 'index'])
        ->name("nekretnineSve");

    Route::get('/{tip}', [NekeretnineController::class, 'index'])
        ->where('tip', "kuće|kuce|stanovi|lokali|poljoprivredno_zemljište|poljoprivredno_zamljiste|poljoprivredno_zemlji%C5%A1te|placevi")
        ->name("nekretnineSvePoTipu");
});


Route::fallback(function () {
    abort(404);
});
