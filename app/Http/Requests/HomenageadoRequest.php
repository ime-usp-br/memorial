<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomenageadoRequest extends FormRequest
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
            'nome' => 'required',
            'data_nascimento' => 'nullable|date_format:d/m/Y',
            'data_falecimento' => 'nullable|date_format:d/m/Y',
            'biografia' => 'nullable',
            'foto_perfil' => 'nullable|image',
            'funcao' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'data_nascimento.date_format' => 'Formato da data inválido.',
            'data_falecimento.date_format' => 'Formato da data inválido.',
            'foto_perfil.image' => 'A foto de perfil precisa ser uma imagem.'
        ];
    }
}
