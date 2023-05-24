<?php

namespace App\Services\Sed\Classrooms;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class FormationClassroomService extends SedAuthService
{
    /**
     * Pega os dados da sala no SED pelo código da sala com a formação da turma
     *
     */
    public function __invoke($codSala)
    {
        $cidade = parent::getConfigSystemSed();
        if (!$cidade) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $response = parent::get(
            SedRouters::FORMACAO_TURMA->value,
            [
                'inNumClasse' => $codSala,
            ]
        );

        return $response->collect();
    }
}
