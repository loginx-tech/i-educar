<?php

namespace App\Services\Sed\Escolas;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class GetAlunoService extends SedAuthService
{
    /**
     * Retorna a ficha do aluno pelo RA.
     *
     */
    public function __invoke($codEscola)
    {
        // $response = parent::get(
        //     SedRouters::GET_ESCOLA->value,
        //     [
        //         'inNumRA'     => $ra,
        //     ]
        // );

        // return $response;
    }
}
