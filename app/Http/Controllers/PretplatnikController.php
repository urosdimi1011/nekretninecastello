<?php

namespace App\Http\Controllers;

use App\Models\Mesto;
use App\Models\Pretplatnik;
use App\Models\PretplatnikFilter;
use App\Models\PretplatnikAtribut;
use App\Models\TipNekretnine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PretplatnikController extends Controller
{
    public function getMesta()
    {
        return response()->json(
            Mesto::orderBy('naziv')->get(['id', 'naziv', 'slug'])
        );
    }

    public function getAtributi($tipId)
    {
        $tip = TipNekretnine::with('atributi')->findOrFail($tipId);
        return response()->json($tip->atributi->map(fn($a) => [
            'id'    => $a->id,
            'naziv' => $a->naziv,
        ]));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'email'       => 'required|email',
        //     'id_tipa'     => 'required|exists:tip_nekretnine,id',
        //     'cena_min'    => 'nullable|numeric|min:0',
        //     'cena_max'    => 'nullable|numeric|min:0|gte:cena_min',
        //     'kvadratura_min' => 'nullable|numeric|min:0',
        //     'kvadratura_max' => 'nullable|numeric|min:0|gte:kvadratura_min',
        //     'mesta'       => 'nullable|array',
        //     'mesta.*'     => 'exists:mesta,id',
        // ]);

        // $pretplatnik = Pretplatnik::firstOrCreate(
        //     ['email' => $request->email],
        //     ['token' => Str::random(64)]
        // );

        // // Proveri duplikat filter
        // // $postojeci = App\Http\Controllers\PretplatnikFilter::where('pretplatnik_id', $pretplatnik->id)
        // //     ->where('id_tipa', $request->id_tipa)
        // //     ->first();

        // if ($postojeci && $pretplatnik->verified_at) {
        //     return response()->json(['greska' => 'Već ste prijavljeni za ovaj tip nekretnine.'], 422);
        // }

        // if ($postojeci && !$pretplatnik->verified_at) {
        //     Mail::to($pretplatnik->email)->send(new \App\Mail\VerifikacijaPretplate($pretplatnik));
        //     return response()->json(['uspeh' => true, 'poruka' => 'Verifikacioni mejl je ponovo poslat.']);
        // }

        // // Kreiraj filter
        // $filter = PretplatnikFilter::create([
        //     'pretplatnik_id' => $pretplatnik->id,
        //     'id_tipa'        => $request->id_tipa,
        //     'cena_min'       => $request->cena_min,
        //     'cena_max'       => $request->cena_max,
        //     'cena_po_metru'  => $request->boolean('cena_po_metru'),
        //     'kvadratura_min' => $request->kvadratura_min,
        //     'kvadratura_max' => $request->kvadratura_max,
        // ]);

        // // Sačuvaj mesta
        // if ($request->mesta) {
        //     $filter->mesta()->sync($request->mesta);
        // }

        // // Sačuvaj atribute
        // if ($request->atributi) {
        //     foreach ($request->atributi as $atributId => $vrednost) {
        //         if (is_array($vrednost)) {
        //             PretplatnikAtribut::create([
        //                 'filter_id'    => $filter->id,
        //                 'atribut_id'   => $atributId,
        //                 'vrednost_min' => $vrednost['min'] ?? null,
        //                 'vrednost_max' => $vrednost['max'] ?? null,
        //             ]);
        //         } else {
        //             PretplatnikAtribut::create([
        //                 'filter_id'  => $filter->id,
        //                 'atribut_id' => $atributId,
        //                 'vrednost'   => $vrednost,
        //             ]);
        //         }
        //     }
        // }

        // Mail::to($pretplatnik->email)->send(new \App\Mail\VerifikacijaPretplate($pretplatnik));

        // return response()->json(['uspeh' => true]);
    }

    public function verifikuj($token)
    {
        $pretplatnik = Pretplatnik::where('token', $token)->firstOrFail();
        $pretplatnik->update(['verified_at' => now()]);
        return redirect('/')->with('success', 'Uspešno ste potvrdili pretplatu!');
    }

    public function odjava($token)
    {
        Pretplatnik::where('token', $token)->delete();
        return redirect('/')->with('success', 'Uspešno ste se odjavili.');
    }
}
