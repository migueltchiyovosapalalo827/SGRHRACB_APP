<?php

namespace App\Models;

use App\Models\Traits\UserACLTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UserACLTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
      /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['cargos'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    public function cargos(): BelongsToMany
    {
        # code...
        return $this->belongsToMany(Cargo::class, 'user_has_cargo');
    }
//relação de um para um com a tabela de efectivo
    public function efectivo(): BelongsTo
    {
        # code...
        return $this->belongsTo(Efectivo::class);
    }

    public function adminlte_image()
    {
      return  $this->foto ? asset('fotos/'.$this->foto) :  'https://i.imgur.com/4MQfHvA.png' ;
    }

    public function adminlte_desc()
    {
        return $this->name . ' - ' . $this->cargos->implode('nome', ', ');


    }

    public function adminlte_profile_url()
    {
        return route('user.show',['id'=>$this->id]);
    }
}
