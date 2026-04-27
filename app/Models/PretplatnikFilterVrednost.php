<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretplatnikFilterVrednost extends Model
{
    protected $table = 'pretplatnik_filter_vrednosti';
    protected $fillable = [
        'filter_id',
        'filter_definicija_id',
        'vrednost',
        'vrednost_min',
        'vrednost_max',
    ];

    public function definicija()
    {
        return $this->belongsTo(FilterDefinicija::class, 'filter_definicija_id');
    }
}
