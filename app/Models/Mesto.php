<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesto extends Model
{
    protected $table = 'mesta';
    protected $fillable = ['naziv', 'slug', 'aktivan'];
    protected $casts = ['aktivan' => 'boolean'];

    public function nekretnine()
    {
        return $this->hasMany(Nekretnine::class, 'mesto_id');
    }

    public function scopeAktivni($query)
    {
        return $query->where('aktivan', true);
    }
}
