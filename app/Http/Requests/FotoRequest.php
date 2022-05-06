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
            'fotos' => 'required',
            'fotos.*' => 'image',
            'homenageado_id' => 'required|exists:App\Models\Homenageado,id'
        ];
    }

    public function messages()
    {
        return [
            'fotos.required' => 'A foto é obrigatória.',
            'fotos.*.image' => 'O arquivo precisa ser uma foto.'
        ];
    }
}
