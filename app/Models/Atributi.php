<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atributi extends Model
{
    protected $table = "atributi";
    protected $fillable  = ['naziv', 'ikonica_klasa'];

    public function tipoviNekretnina()
    {
        return $this->belongsToMany(TipNekretnine::class, 'tip_nekretnine_atributi', 'id_atributa');
    }

    public function tipNekretnineAtributi()
    {
        return $this->hasMany(Nekretnine_Atributi::class, 'id_atributa', 'id');
    }

    public function prevodi()
    {
        return $this->hasMany(AtributPrevod::class, 'atribut_id', 'id');
    }

    public function prevod(?string $locale = null): object
    {
        $locale = $locale ?? app()->getLocale();

        $prevod = $this->prevodi->firstWhere('locale', $locale)
            ?? $this->prevodi->firstWhere('locale', 'sr');

        return (object) [
            'naziv' => $prevod?->naziv ?? $this->naziv,
        ];
    }
}
