<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presenca extends Model
{
    use HasFactory;
    protected $fillable = ['ausente','motivo'];
    protected $appends = ['date'];

    public function getDateAttribute()
    {
        # code...
        return Carbon::parse($this->attributes['created_at'])->format('d-m-Y');
    }

    public function efectivo():BelongsTo
    {
        # code...
        return $this->belongsTo(Efectivo::class);
    }



}
