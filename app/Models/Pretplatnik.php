<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pretplatnik extends Model
{
    protected $table = 'pretplatnici';
    protected $fillable = ['email', 'token', 'verified_at'];
    protected $casts = ['verified_at' => 'datetime'];


    public function filteri()
    {
        return $this->hasMany(PretplatnikFilter::class, 'pretplatnik_id');
    }

    public function jeVerifikovan(): bool
    {
        return $this->verified_at !== null;
    }
}
