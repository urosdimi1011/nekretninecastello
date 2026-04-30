<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    protected $table = 'videos';

    protected $fillable = [
        'url',
        'nekretnina_id'
    ];

    public function nekretnina()
    {
        return $this->belongsTo(Nekretnine::class, 'nekretnina_id');
    }
}
