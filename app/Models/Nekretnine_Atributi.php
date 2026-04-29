<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nekretnine_Atributi extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table = 'tip_nekretnine_atributi';

    public function ucitajAtribut()
    {
        return $this->belongsTo(Atributi::class, 'id_atributa');
    }

    public function ucitajTip()
    {
        return $this->belongsTo(TipNekretnine::class, 'id_tip_nekretnine');
    }
}
