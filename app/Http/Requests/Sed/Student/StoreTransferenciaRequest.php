<?php

namespace App\Http\Requests\Sed\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransferenciaRequest extends FormRequest
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
            // 'inNumClasseMatriculaAtual' => 'required|integer',
            'inCodEscola'               => 'required|integer',
            'inFase'                    => 'required|integer',
            'inInteresseIntegral'       => 'required|integer',
            'inMotivo'                  => 'required|integer',
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
            'inCodEscola.required' => 'O campo escola é obrigatório',
            'inFase.required' => 'O campo tipo de tranferência é obrigatório',
            'inInteresseIntegral.required' => 'O campo interesse em integral é obrigatório',
            'inMotivo.required' => 'O campo motivo é obrigatório',
        ];
    }
}
