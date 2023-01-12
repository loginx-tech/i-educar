<?php

namespace App\Http\Requests;

use App\Enums\SedCorRacas;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SedStoreAlunoRequest extends FormRequest
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
            'inNomeAluno'   => 'required|string|max:100',
            'inNomeMae'     => 'required|string|max:100',
            'inNomePai'     => 'nullable|string|max:100',
            'inNomeSocial'  => 'nullable|string|max:100',
            'inNomeAfetivo' => 'nullable|string|max:100',
            'inDataNascimento' => 'required|date',
            'inCorRaca'    => ['required', new Enum(SedCorRacas::class)],
            'inSexo'       => 'required|integer',
            'inEmail'      => 'nullable|email|string|max:100',
            'inNacionalidade' => 'required|integer',

            'inNomeMunNascto' => 'required_if:inNacionalidade,1',
            'inUFMunNascto'   => 'required_if:inNacionalidade,1',

            'inCodPaisOrigem' => 'required|integer', //76 default
            'inPaisOrigem' => 'required|string|max:60', //Brasil default

            'inCodMunNasctoDNE' => 'nullable',
            'inDataEntradaPais' => 'nullable|date|required_if:inNacionalidade,2',

            'inBolsaFamilia' => 'nullable|integer', // 0 nao, 1 sim
            'inQuilombola' => 'nullable|integer', // 0 nao, 1 sim

            'inPossuiInternet' => 'required|string|max:1', // N nao, S sim
            'inPossuiNotebookSmartphoneTablet' => 'required|string|max:1', // N nao, S sim

            'inTipoSanguineo' => 'nullable', // ENUM
            'inDoadorOrgaos' => 'nullable|string|max:3', // SIM, NÃO
            'inNumeroCNS' => 'nullable|string|max:15',

            // Documentos
            'inCodigoINEP' => 'nullable|string|max:12',
            'inCPF' => 'nullable|string|max:11',
            'inNumNIS' => 'nullable|string|max:11',
            'inNumDoctoCivil' => 'nullable|string|max:14', //RG ou RNE
            'inDigitoDoctoCivil' => 'nullable|string|max:2',
            'inUFDoctoCivil' => 'nullable|string|max:2',
            'inDataEmissaoDoctoCivil' => 'nullable|date',
            'inJustificativaDocumentos' => 'nullable|integer|between:0,1', // 0, 1

            // inCertidaoNova[] - tem que inserir (opcional)

            // inCertidaoAntiga[] - tem que inserir (opcional)

            // inEnderecoResidencial
            'inLogradouro' => 'required|string|max:100',
            'inNumero' => 'required|string|max:10',
            'inAreaLogradouro' => 'required|string|max:10', // 0 Rural, 1 Urbano - ENUM
            'inComplemento' => 'nullable|string|max:60',
            'inBairro' => 'required|string|max:60',
            'inCep' => 'required|string|max:8',
            'inNomeCidade' => 'required|string|max:60',
            'inUFCidade' => 'required|string|max:2',
            'inCodMunicipioDNE' => 'nullable|string|max:6',
            'inLatitude' => 'required|string|max:100',
            'inLongitude' => 'required|string|max:100',
            'inCodLocalizacaoDiferenciada' => 'nullable|string|max:1', // ENUM

            // inDeficiencia[] - tem que inserir (opcional)

            // inRecursoAvaliacao[] - tem que inserir (opcional)

            // inRastreio[] - tem que inserir (opcional)
        ];
    }
}
