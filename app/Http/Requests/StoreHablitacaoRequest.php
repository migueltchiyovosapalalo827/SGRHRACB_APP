<?php

namespace App\Http\Requests;

use App\Enum\HablitacaoTipoEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreHablitacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'nome' => 'required|string|max:255',
            'tipo' =>['required', new Enum(HablitacaoTipoEnum::class)],
            'nivel'=> 'required|string|max:255',
            'efectivo' => 'required|integer|exists:efectivos,id',
        ];
    }
}
