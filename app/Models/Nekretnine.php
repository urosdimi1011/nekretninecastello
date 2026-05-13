<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nekretnine extends Model
{
    use SoftDeletes;
    protected $table = "nekretnine";

    protected $fillable = ["naziv", "opis", "slug", "cena", "cena_metar", "id_slike", "id_tip_nekretnine", "sifra_nekretnine", "link_ka_videu", "link_ka_videu_virtual", "istaknuta", "mesto_id"];


    public function slike()
    {
        return $this->belongsToMany(Slike::class, 'nekretnine_slike', 'id_nekretnine', 'id_slike');
    }
    public function slika()
    {
        return $this->hasOne(Slike::class, 'id', 'id_slike');
    }

    public function tip()
    {
        return $this->hasOne(TipNekretnine::class, 'id', 'id_tip_nekretnine');
    }
    public function atributiVrednosti()
    {
        return $this->hasMany(NekretnineAtributiVrednost::class, 'id_nekretnine');
    }
    public function mesto()
    {
        return $this->belongsTo(Mesto::class, 'mesto_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function vrednostAtributa(string $naziv): mixed
    {
        return ($this->atributiVrednosti ?? collect())
            ->firstWhere('naziv', $naziv)?->vrednost;
    }

    public function video()
    {
        return $this->hasOne(Video::class, 'nekretnina_id');
    }

    public function prevodi()
    {
        return $this->hasMany(NekretninaPrevod::class, 'nekretnina_id');
    }

    public function prevod(?string $locale = null): object
    {
        $locale = $locale ?? app()->getLocale();

        $prevod = $this->prevodi->firstWhere('locale', $locale)
            ?? $this->prevodi->firstWhere('locale', 'sr');

        return (object) [
            'naziv' => $prevod?->naziv ?? $this->naziv,
            'opis'  => $prevod?->opis  ?? $this->opis,
        ];
    }
}
