<?php

namespace App\Services\Sed\Classrooms;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class GetClassroomsService extends SedAuthService
{
    /**
     * Pega os dados das salas no SED pelo código da escola
     *
     */
    public function __invoke($codEscola, $anoLetivo = null)
    {
        $cidade = parent::getConfigSystemSed();
        if (!$cidade) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $response = parent::get(
            SedRouters::GET_SALAS->value,
            [
                'inAnoLetivo'  => $anoLetivo ? $anoLetivo : date('Y'),
                'inCodEscola' => $codEscola,
            ]
        );

        return $response->collect();
    }
}
