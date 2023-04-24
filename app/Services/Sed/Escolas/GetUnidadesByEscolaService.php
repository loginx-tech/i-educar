<?php

namespace App\Services\Sed\Escolas;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class GetUnidadesByEscolaService extends SedAuthService
{
    /**
     * Retorna todas as escolas cadastradas no SED na diretoria informada
     *
     * @param int $codEscola Caso queria uma escola especifica apenas, não há rota para isso no SED
     */
    public function __invoke($codEscola)
    {
        $cidade = parent::getConfigSystemSed();
        if (!$cidade) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $response = parent::get(
            SedRouters::GET_UNIDADES->value,
            [
                'inCodEscola' => $codEscola,
            ]
        );

        return $response;
    }
}
