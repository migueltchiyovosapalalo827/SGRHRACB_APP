<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promocoes extends Model
{
    use HasFactory;
    protected $fillable = ['anterior','actual','anterior_subcategoria_id'];

    public function efectivo():BelongsTo
    {
        return $this->belongsTo(Efectivo::class);
    }

    public function Subcategoria_anterior():BelongsTo
    {
        return $this->belongsTo(Subcategoria::class,"anterior_subcategoria_id");
    }


}
