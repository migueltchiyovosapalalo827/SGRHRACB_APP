<?php

namespace App\Http\Requests;

use App\Enum\EfectivoFpsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreEfectivoRequest extends FormRequest
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
            'categoria' => 'required|array',
            'subcategoria' => 'required',
            'unidade' => 'required',
            'cargo'=>'required',
            'quadro_especial' => 'required',
            'data_de_nascimento' => 'required|date',
            'data_de_incorporacao' => 'required|date',
            'data_de_emissao' => 'required|date',
            'fliacao' => 'required|string|max:255',
            'forma_de_prestacao_de_servico' => ['required',new Enum(EfectivoFpsEnum::class)],
            'numero_do_bi' => 'required|min:14|regex:/^[0-9]{9}[A-Z]{2}[0-9]{3}$/',
            'iban' => 'required|min:24|regex:/^([A-Z]{2}[ \-]?[0-9]{2})(?=(?:[ \-]?[A-Z0-9]){9,30}$)((?:[ \-]?[A-Z0-9]{3,5}){2,7})([ \-]?[A-Z0-9]{1,3})?$/',
            'nip' => 'required|min:9',
            'genero' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
