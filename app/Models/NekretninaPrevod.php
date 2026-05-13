<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NekretninaPrevod extends Model
{
    protected $table = "nekretnine_prevodi";
    protected $fillable = ["nekretnina_id", "locale", "naziv", "opis"];
}
