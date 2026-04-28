<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pretplatnik extends Model
{
    protected $table = 'pretplatnici';
    protected $fillable = ['email'];


    public function filteri()
    {
        return $this->hasMany(PretplatnikFilter::class, 'pretplatnik_id');
    }
}
