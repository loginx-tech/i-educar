<?php

namespace App\Services\Sed\Alunos;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class GetAlunoService extends SedAuthService
{
    /**
     * Retorna a ficha do aluno pelo RA.
     *
     */
    public function __invoke($ra, $siglaUFRA = 'SP')
    {
        $response = parent::get(
            SedRouters::GET_ALUNO->value,
            [
                'inNumRA'     => $ra,
                'inSiglaUFRA' => $siglaUFRA,
            ]
        );

        return $response;
    }
}
