<?php

namespace App\Services\Sed\Escolas;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class GetEscolaByName extends SedAuthService
{
    /**
     * Retorna todas as escolas cadastradas no SED na diretoria informada
     *
     * @param int $codEscola  Caso queria uma escola especifica apenas, não há rota para isso no SED
     */
    public function __invoke($nameEscola)
    {
        $cidade = Parent::getConfigSystemSed();
        if (!$cidade) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $response = parent::get(
            SedRouters::GET_ESCOLA->value,
            [
                'inNomeEscola' => $nameEscola,
            ]
        );

        //Como a busca é por nome ele retorna um array, então pego o primeiro elemento com o nome da cidade: TO-DO: Melhorar isso
        return collect($response->object()->outEscolas)->firstWhere('outNomeDistrito', $cidade);

        //return $response->collect()->firstWhere('outCodEscola', $codEscola);
    }
}
