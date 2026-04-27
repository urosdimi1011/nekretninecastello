<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretplatnikFilter extends Model
{
    protected $table = 'pretplatnik_filteri';
    protected $fillable = [
        'pretplatnik_id',
        'id_tipa',
        'cena_min',
        'cena_max',
        'cena_po_metru',
        'kvadratura_min',
        'kvadratura_max',
    ];
    protected $casts = [
        'cena_po_metru' => 'boolean',
    ];

    public function pretplatnik()
    {
        return $this->belongsTo(Pretplatnik::class, 'pretplatnik_id');
    }

    public function tip()
    {
        return $this->belongsTo(TipNekretnine::class, 'id_tipa');
    }

    public function vrednosti()
    {
        return $this->hasMany(PretplatnikFilterVrednost::class, 'filter_id');
    }

    public function mesta()
    {
        return $this->vrednosti()
            ->whereHas('definicija', fn($q) => $q->where('kljuc', 'lokacija'));
    }
}
