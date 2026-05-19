<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtributPrevod extends Model
{
    protected $table = "atributi_prevodi";
    protected $fillable = ["atribut_id", "locale", "naziv"];
}
