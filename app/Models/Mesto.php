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
    public function prevodi()
    {
        return $this->hasMany(MestoPrevod::class, 'mesto_id');
    }

    public function prevod(?string $locale = null): object
    {
        $locale = $locale ?? app()->getLocale();

        $prevod = $this->prevodi->firstWhere('locale', $locale)
            ?? $this->prevodi->firstWhere('locale', 'sr');

        return (object) [
            'naziv' => $prevod?->naziv ?? $this->naziv,
        ];
    }
}
