<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Efectivo extends Model
{
    use HasFactory;
    protected $fillable = ['nome','nip','numero_do_bi','data_de_emissao','data_de_nascimento','data_de_incorporacao','foto'
                          ,'genero','iban','fliacao','fps','quadro_especial_id','unidade_id','subcategoria_id','cargo_id'];
    protected $appends =['age','tempo_de_servico'];

      /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['user'];
    public function getAgeAttribute()
    {
        # code...
        return Carbon::parse($this->attributes['data_de_nascimento'])->age;
    }
    public function getTempoDeServicoAttribute()
    {
        # code...
        return Carbon::parse($this->attributes['data_de_incorporacao'])->diffInYears(Carbon::now());
    }

    public function subcategoria():BelongsTo
    {
        return $this->belongsTo(Subcategoria::class);
    }


    public function unidade():BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }

    public function quadro_especial():BelongsTo
    {
        return $this->belongsTo(Quadro_especial::class);
    }

    public function promocoes():HasMany
    {
        return $this->hasMany(Promocoes::class);
    }

    public function hablitacoes():HasMany
   {
    # code...
    return $this->hasMany(Hablitacao::class);
   }
   //relação de um para um com a tabela de efectivo
    public function user():HasOne
    {
        # code...
        return $this->hasOne(User::class);
    }

    public function cargo():BelongsTo
    {
        # code...
        return $this->belongsTo(Cargo::class);
    }
     public function presencas():HasMany
     {
        # code...
        return $this->hasMany(Presenca::class);
     }

}
