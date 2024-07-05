<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class NekretnineAtributiVrednost extends Model
{
    public $timestamps = false;
    protected $table = "nekretnine_atributi_vrednosi";


    protected $fillable = ["id_tip_nekretnine_atributi","id_nekretnine","vrednost"];


    public function nestoMoje()
    {
        return $this->hasOne(Nekretnine_Atributi::class, 'id', 'id_tip_nekretnine_atributi');
    }


    public function nestoMoje1()
    {
        return $this->belongsTo(NekretnineAtributiVrednost::class, 'id', 'id_tip_nekretnine_atributi');
    }


}
