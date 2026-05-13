<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipNekretninePrevod extends Model
{
    protected $table = "tip_nekretnine_prevodi";
    protected $fillable = ["tip_nekretnine_id", "locale", "tip"];
}
