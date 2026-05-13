<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipNekretnine extends Model
{
    use HasFactory;
    protected $table = "tip_nekretnine";
    protected $fillable = ["tip", "id_slike"];



    public function atributi()
    {
        return $this->belongsToMany(Atributi::class, 'tip_nekretnine_atributi', 'id_tip_nekretnine', 'id_atributa')
            ->withPivot("id");
    }
    public function slika()
    {
        return $this->hasOne(Slike::class, 'id', 'id_slike');
    }
    public function filteri()
    {
        return $this->belongsToMany(
            FilterDefinicija::class,
            'filter_definicija_tip_nekretnine',
            'tip_nekretnine_id',
            'filter_definicija_id'
        );
    }
    public function prevodi()
    {
        return $this->hasMany(TipNekretninePrevod::class, 'tip_nekretnine_id');
    }

    public function prevod(?string $locale = null): object
    {
        $locale = $locale ?? app()->getLocale();

        $prevod = $this->prevodi->firstWhere('locale', $locale)
            ?? $this->prevodi->firstWhere('locale', 'sr');

        return (object) [
            'tip' => $prevod?->tip ?? $this->tip,
        ];
    }
}
