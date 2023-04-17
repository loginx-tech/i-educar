<?php

namespace App\Services\Sed\DadosBasicos;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class GetTiposEnsinoService extends SedAuthService
{
    /**
     * Retorna os tipos de ensino.
     *
     */
    public function __invoke()
    {
        $response = parent::get(
            SedRouters::TIPOS_ENSINO->value, []
        );

        return $response;
    }
}
