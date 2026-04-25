<?php

namespace App\Http\Controllers;

use App\Models\Pretplatnik;
use App\Models\TipNekretnine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PretplatnikController extends Controller
{
    public function getAtributi($tipId)
    {
        $tip = TipNekretnine::with('atributi')->findOrFail($tipId);
        return response()->json($tip->atributi->map(function ($a) {
            return [
                'id' => $a->id,
                'naziv' => $a->naziv,
            ];
        }));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'   => 'required|email',
            'id_tipa' => 'required|exists:tip_nekretnine,id',
        ]);

        Pretplatnik::create([
            'email'             => $request->email,
            'id_tipa'           => $request->id_tipa,
            'cena_min'          => $request->cena_min ?: null,
            'cena_max'          => $request->cena_max ?: null,
            'cena_po_metru'     => $request->boolean('cena_po_metru'),
            'kvadratura_min'    => $request->kvadratura_min ?: null,
            'kvadratura_max'    => $request->kvadratura_max ?: null,
            'atributi_vrednosti' => $request->atributi ?: null,
            'token'             => Str::random(64),
        ]);

        return response()->json(['uspeh' => true]);
    }
}
