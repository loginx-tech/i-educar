<?php

namespace App\Services\Sed\Classrooms;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class GetClassroomService extends SedAuthService
{
    /**
     * Pega os dados da sala no SED pelo código da sala
     *
     */
    public function __invoke($codSala, $anoLetivo = null)
    {
        $cidade = parent::getConfigSystemSed();
        if (!$cidade) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $response = parent::get(
            SedRouters::GET_SALA->value,
            [
                'inAnoLetivo' => $anoLetivo ? $anoLetivo : date('Y'),
                'inNumClasse' => $codSala,
            ]
        );

        return $response->collect();
    }
}
