<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nekretnine extends Model
{
    use SoftDeletes;
    protected $table="nekretnine";

    protected $fillable = ["naziv","opis","cena","cena_metar","id_slike","id_tip_nekretnine","sifra_nekretnine","link_ka_videu","link_ka_videu_virtual","istaknuta"];


    public function slike()
    {
        return $this->belongsToMany(Slike::class, 'nekretnine_slike','id_nekretnine','id_slike');
    }
    public function slika()
    {
        return $this->hasOne(Slike::class, 'id','id_slike');
    }

    public function tip()
    {
        return $this->hasOne(TipNekretnine::class, 'id','id_tip_nekretnine');
    }

}
