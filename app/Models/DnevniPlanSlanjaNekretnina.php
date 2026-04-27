<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DnevniPlanSlanjaNekretnina extends Model
{
    protected $table = 'dnevni_plan_slanja_nekretnina';

    protected $fillable = [
        'pretplatnik_id',
        'nekretnina_id',
        'planirano_za',
        'poslato_u',
    ];

    protected $casts = [
        'planirano_za' => 'datetime',
        'poslato_u' => 'datetime',
    ];

    public function pretplatnik(): BelongsTo
    {
        return $this->belongsTo(Pretplatnik::class);
    }

    public function nekretnina(): BelongsTo
    {
        return $this->belongsTo(Nekretnine::class, 'nekretnina_id');
    }
}
