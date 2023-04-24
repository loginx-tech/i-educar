<?php

namespace App\Http\Requests\Sed\Class;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateClassRequest extends FormRequest
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
            'inAnoLetivo' => 'required|date_format:Y',
            'inCodEscola' => 'required|exists:escola,cod_escola',
            // 'inNumClasse' => 'required|integer',
            'inCodTipoClasse' => 'required|integer',
            'inCodTurno' => 'required|integer',
            'inTurma' => 'required|string',
            'inNrCapacidadeFisicaMaxima' => 'required|integer',
            'inDataInicioAula' => 'required|date',
            'inDataFimAula' => 'required|date',
            'inHorarioInicioAula' => 'required',
            'inHorarioFimAula' => 'required',
            'inCodDuracao' => 'required|integer',
            'inCodHabilitacao' => 'nullable|integer',
            'inCodigoAtividadeComplementar' => 'nullable|array',
            'inCodigoAtividadeComplementar.*' => 'required|string',
            'inNumeroSala' => 'required|string',
            'inCodSerieAno' => 'nullable',
            // 'inDiasSemana' => 'nullable|array',
            // 'inDiasSemana.inFlagSegunda' => 'nullable|string',
            // 'inDiasSemana.inHoraIniAulaSegunda' => 'nullable|date_format:H:i',
            // 'inDiasSemana.inHoraFimAulaSegunda' => 'nullable|date_format:H:i',
            // 'inDiasSemana.inFlagTerca' => 'nullable|string',
            // 'inDiasSemana.inHoraIniAulaTerca' => 'nullable|date_format:H:i',
            // 'inDiasSemana.inHoraFimAulaTerca' => 'nullable|date_format:H:i',
            // 'inDiasSemana.inFlagQuarta' => 'nullable|string',
            // 'inDiasSemana.inHoraIniAulaQuarta' => 'nullable|date_format:H:i',
            // 'inDiasSemana.inHoraFimAulaQuarta' => 'nullable|date_format:H:i',
            // 'inDiasSemana.inFlagQuinta' => 'nullable|string',
            // 'inDiasSemana.inHoraIniAulaQuinta' => 'nullable|date_format:H:i',
            // 'inDiasSemana.inHoraFimAulaQuinta' => 'nullable|date_format:H:i',
            // 'inDiasSemana.inFlagSexta' => 'nullable|string',
            // 'inDiasSemana.inHoraIniAulaSexta' => 'nullable|date_format:H:i',
            // 'inDiasSemana.inHoraFimAulaSexta' => 'nullable|date_format:H:i',
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
            'inAnoLetivo.required' => 'O campo ano letivo é obrigatório.',
            'inAnoLetivo.date_format' => 'O campo ano letivo deve ser um ano válido.',
            'inCodEscola.required' => 'O campo escola é obrigatório.',
            'inCodEscola.exists' => 'O campo escola deve ser um código válido.',
            // 'inNumClasse.required' => 'O campo número da classe é obrigatório.',
            // 'inNumClasse.integer' => 'O campo número da classe deve ser um número inteiro.',
            'inCodTipoClasse.required' => 'O campo tipo de classe é obrigatório.',
            'inCodTipoClasse.integer' => 'O campo tipo de classe deve ser um número inteiro.',
            'inCodTurno.required' => 'O campo turno é obrigatório.',
            'inCodTurno.integer' => 'O campo turno deve ser um número inteiro.',
            'inTurma.required' => 'O campo turma é obrigatório.',
            'inTurma.string' => 'O campo turma deve ser uma string.',
            'inNrCapacidadeFisicaMaxima.required' => 'O campo capacidade física máxima é obrigatório.',
            'inNrCapacidadeFisicaMaxima.integer' => 'O campo capacidade física máxima deve ser um número inteiro.',
            'inDataInicioAula.required' => 'O campo data de início das aulas é obrigatório.',
            'inDataInicioAula.date' => 'O campo data de início das aulas deve ser uma data válida.',
            'inDataFimAula.required' => 'O campo data de fim das aulas é obrigatório.',
            'inDataFimAula.date' => 'O campo data de fim das aulas deve ser uma data válida.',
            'inHorarioInicioAula.required' => 'O campo horário de início das aulas é obrigatório.',
            // 'inHorarioInicioAula.date_format' => 'O campo horário de início das aulas deve ser uma hora válida.',
            'inHorarioFimAula.required' => 'O campo horário de fim das aulas é obrigatório.',
            // 'inHorarioFimAula.date_format' => 'O campo horário de fim das aulas deve ser uma hora válida.',
            'inCodDuracao.required' => 'O campo duração é obrigatório.',
            'inCodDuracao.integer' => 'O campo duração deve ser um número inteiro.',
            //'inCodHabilitacao.integer' => 'O campo habilitação deve ser um número inteiro.',
            // 'inCodigoAtividadeComplementar.array' => 'O campo atividade complementar deve ser um array.',
            // 'inCodigoAtividadeComplementar.*.required' => 'O campo atividade complementar é obrigatório.',
            // 'inCodigoAtividadeComplementar.*.string' => 'O campo atividade complementar deve ser uma string.',
            'inNumeroSala.required' => 'O campo número da sala é obrigatório.',
            'inNumeroSala.string' => 'O campo número da sala deve ser uma string.',

        ];
    }
}
