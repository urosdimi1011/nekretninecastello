<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pretplatnik extends Model
{
    protected $table = 'pretplatnici';
    protected $fillable = [
        'email',
        'id_tipa',
        'cena_min',
        'cena_max',
        'cena_po_metru',
        'kvadratura_min',
        'kvadratura_max',
        'atributi_vrednosti',
        'token'
    ];

    protected $casts = [
        'atributi_vrednosti' => 'array',
        'cena_po_metru' => 'boolean',
    ];

    public function tip()
    {
        return $this->belongsTo(TipNekretnine::class, 'id_tipa');
    }
}
