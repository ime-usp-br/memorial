<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MensagemRequest extends FormRequest
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
        $rules = [
            'nome' => 'required',
            'email' => 'required|email',
            'instituicao' => 'required',
            'mensagem' => 'required',
            'homenageado_id' => 'required|exists:App\Models\Homenageado,id',
            'estado' => 'nullable'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Formato de email inválido.',
            'instituicao.required' => 'A instituição é obrigatória.',
            'mensagem.required' => 'A mensagem é obrigatória.',
        ];
    }
}
