<?php

namespace App\Http\Requests\Sed\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreRemanejamento extends FormRequest
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
            'inDataMovimento' => 'required|date',
            'inNumClasseDestino' => 'required|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'inDataMovimento.required' => 'A data do movimento é obrigatória.',
            'inDataMovimento.date' => 'A data do movimento deve ser uma data válida.',
            'inNumClasseDestino.required' => 'O número da classe destino é obrigatório.',
            'inNumClasseDestino.integer' => 'O número da classe destino deve ser um número inteiro.',
        ];
    }
}
