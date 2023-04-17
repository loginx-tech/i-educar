<?php

namespace App\Http\Requests\Sed;

use Illuminate\Foundation\Http\FormRequest;

class SetClassCodeRequest extends FormRequest
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
            'inCodSed' => 'required|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages() {
        return [
            'inCodSed.required' => 'Código da turma é obrigatório.',
            'inCodSed.integer' => 'Código da turma deve ser um número inteiro.',
        ];
    }
}
