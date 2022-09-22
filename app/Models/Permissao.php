<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permissao extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];

    public function cargos():BelongsToMany
    {
       # code...
       return $this->belongsToMany(Cargo::class, 'permissao_has_cargo');
    }
}
