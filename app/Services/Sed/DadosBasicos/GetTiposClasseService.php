<?php

namespace App\Services\Sed\DadosBasicos;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class GetTiposClasseService extends SedAuthService
{
    /**
     * Retorna os tipos de classe.
     *
     */
    public function __invoke()
    {
        $response = parent::get(
            SedRouters::TIPOS_CLASSE->value, []
        );

        return $response;
    }
}
