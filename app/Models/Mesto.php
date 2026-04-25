<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesto extends Model
{
    protected $table = 'mesta';
    protected $fillable = ['naziv', 'slug'];

    public function nekretnine()
    {
        return $this->hasMany(Nekretnine::class, 'mesto_id');
    }
}
