<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterDefinicija extends Model
{
    use HasFactory;
    protected $table = 'filter_definicije';
    protected $fillable = [
        'kljuc',
        'naziv',
        'tip',
        'opcije',
        'jedinica',
        'obavezan',
        'sort_order',
        'aktivan'
    ];
    protected $casts = [
        'opcije'   => 'array',
        'obavezan' => 'boolean',
        'aktivan'  => 'boolean',
    ];

    const TIP_RASPON      = 'raspon';
    const TIP_KATEGORIJA  = 'kategorija';
    const TIP_BOOLEAN     = 'boolean';
    const TIP_VISE_IZBORA = 'vise_izbora';
    const TIPOVI = [
        self::TIP_RASPON,
        self::TIP_KATEGORIJA,
        self::TIP_BOOLEAN,
        self::TIP_VISE_IZBORA,
    ];

    public function scopeAktivni($query)
    {
        return $query->where('aktivan', true)->orderBy('sort_order');
    }

    public function tipovi()
    {
        return $this->belongsToMany(
            TipNekretnine::class,
            'filter_definicija_tip_nekretnine',
            'filter_definicija_id',
            'tip_nekretnine_id'
        );
    }
}
