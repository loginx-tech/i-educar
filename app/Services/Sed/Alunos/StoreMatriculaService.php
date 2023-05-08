<?php

namespace App\Services\Sed\Alunos;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class StoreMatriculaService extends SedAuthService
{
    /**
     * Realiza a rematricula de um aluno no SED
     *
     * Todos os parametros são obrigatórios
     */
    public function __invoke($matricula)
    {
        $response = parent::post(
            SedRouters::STORE_MATRICULA->value,
            [
                'inAnoLetivo' => $matricula['inAnoLetivo'],
                'inAluno'       => [
                    'inNumRA'         => isset($matricula['inNumRA']) ? $matricula['inNumRA'] : null,
                    'inDigitoRA'      => isset($matricula['inDigitoRA']) ? $matricula['inDigitoRA'] : null,
                    'inSiglaUFRA'     => isset($matricula['inSiglaUFRA']) ? $matricula['inSiglaUFRA'] : null,
                ],
                'inMatricula'   => [
                    'inDataInicioMatricula' => isset($matricula['inDataInicioMatricula']) ? $matricula['inDataInicioMatricula'] : null,
                    'inNumAluno'            => isset($matricula['inNumAluno']) ? $matricula['inNumAluno'] : null,
                    'inNumClasse'           => isset($matricula['inNumClasse']) ? $matricula['inNumClasse'] : null,
                ],
                'inNivelEnsino' => [
                    'inCodTipoEnsino' => isset($matricula['inCodTipoEnsino']) ? $matricula['inCodTipoEnsino'] : null,
                    'inCodSerieAno'   => isset($matricula['inCodSerieAno']) ? $matricula['inCodSerieAno'] : null,
                ]
            ]
        );

        return $response;
    }
}
