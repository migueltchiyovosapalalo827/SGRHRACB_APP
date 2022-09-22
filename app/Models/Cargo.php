<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];

    public function permissoes(): BelongsToMany
    {
        # code...
        return $this->belongsToMany(Permissao::class, 'permissao_has_cargo');
    }
    //users
    public function users(): BelongsToMany
    {
        # code...
        return $this->belongsToMany(User::class, 'user_has_cargo');
    }

    public function efectivos():HasMany
    {
        # code...
        return $this->hasMany(Efectivo::class);
    }
}
