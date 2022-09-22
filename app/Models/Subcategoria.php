<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategoria extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
    public function efectivos():HasMany
    {
        return $this->hasMany(Efectivo::class);
    }

    public function promocaoAnterior():HasMany
    {
        # code...
        return $this->hasMany(Promocoes::class,"anterior_subcategoria_id");
    }

}
