<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipNekretnine extends Model
{
    use HasFactory;
    protected $table = "tip_nekretnine";
    protected $fillable = ["tip","id_slike"];



    public function atributi()
    {
        return $this->belongsToMany(Atributi::class, 'tip_nekretnine_atributi','id_tip_nekretnine','id_atributa')
            ->withPivot("id");
    }
    public function slika()
    {
        return $this->hasOne(Slike::class, 'id','id_slike');
    }

}
