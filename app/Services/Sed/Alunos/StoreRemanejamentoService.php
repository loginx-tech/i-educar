<?php

namespace App\Services\Sed\Alunos;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class StoreRemanejamentoService extends SedAuthService
{
    /**
     * Remanejamento de aluno
     *
     * Esse método com finalidade efetuar o remanejamento de matrículas (troca de aluno entre classes da
     * mesma escola) atendendo as regras vigentes no sistema Cadastro de Alunos.
     *
     */
    public function __invoke($data)
    {
        $response = parent::post(
            SedRouters::STORE_REMANEJAMENTO->value,
            [
                'inAluno'       => [
                    'inNumRA'     => isset($data['inNumRA']) ? $data['inNumRA'] : null, // Obrigarório
                    'inDigitoRA'  => isset($data['inDigitoRA']) ? $data['inDigitoRA'] : null,
                    'inSiglaUFRA' => isset($data['inSiglaUFRA']) ? $data['inSiglaUFRA'] : null, // Obrigarório
                ],
                'inMatricula'   => [
                    'inDataMovimento'    => isset($data['inDataMovimento']) ? $data['inDataMovimento'] : null, // Obrigarório
                    'inNumAluno'         => isset($data['inNumAluno']) ? $data['inNumAluno'] : 00, // Obrigarório
                    'inNumClasseOrigem'  => isset($data['inNumClasseOrigem']) ? $data['inNumClasseOrigem'] : null, // Obrigarório
                    'inNumClasseDestino' => isset($data['inNumClasseDestino']) ? $data['inNumClasseDestino'] : null, // Obrigarório
                ],
                'inNivelEnsino' => [
                    'inCodTipoEnsino' => isset($data['inCodTipoEnsino']) ? $data['inCodTipoEnsino'] : null, // Obrigarório
                    'inCodSerieAno'   => isset($data['inCodSerieAno']) ? $data['inCodSerieAno'] : null, // Obrigarório
                    'inAnoLetivo'     => isset($data['inAnoLetivo']) ? $data['inAnoLetivo'] : null, // Obrigarório
                ]
            ]
        );

        /* Details


        */

        return $response;
    }
}
