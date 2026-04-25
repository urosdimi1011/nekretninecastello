<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atributi extends Model
{
    protected $table = "atributi";
    protected $fillable  = ['naziv', 'ikonica_klasa'];
    use HasFactory;


    public function tipoviNekretnina()
    {
        return $this->belongsToMany(TipNekretnine::class, 'tip_nekretnine_atributi','id_atributa');
    }

    public function tipNekretnineAtributi()
    {
        return $this->hasMany(Nekretnine_Atributi::class, 'id_atributa', 'id');
    }


}
