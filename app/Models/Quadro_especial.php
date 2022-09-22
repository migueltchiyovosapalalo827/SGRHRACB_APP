<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quadro_especial extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];

    public function efectivos():HasMany
    {
        return $this->hasMany(Efectivo::class);
    }
}
