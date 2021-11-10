<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FotoRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {   
        return [
            'foto' => 'required|image',
            'descricao' => 'nullable',
            'homenageado_id' => 'required|exists:App\Models\Homenageado,id'
        ];
    }

    public function messages()
    {
        return [
            'foto.required' => 'A foto é obrigatória.',
            'foto.image' => 'A foto precisa ser uma imagem.',
        ];
    }
}
