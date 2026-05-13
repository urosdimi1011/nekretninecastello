<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MestoPrevod extends Model
{
    protected $table = "mesto_prevodi";
    protected $fillable = ["mesto_id", "locale", "naziv"];
}
