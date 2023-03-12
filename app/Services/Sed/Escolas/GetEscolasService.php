<?php

namespace App\Services\Sed\Escolas;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class GetEscolasService extends SedAuthService
{
    /**
     * Identificação da diretoria
     *
     * @var int
     */
    protected $diretoria;

    /**
     * Retorna todas as escolas cadastradas no SED na diretoria informada
     *
     * @param int $codEscola Caso queria uma escola especifica apenas, não há rota para isso no SED
     */
    public function __invoke($codEscola = null)
    {
        $cidade = parent::getConfigSystemSed();
        if (!$cidade) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $response = parent::get(
            SedRouters::GET_ESCOLAS->value,
            [
                //'inCodDiretoria'  => config('sed.diretoriaId_' . 'JACEREI'),
                'inCodMunicipio'  => config('sed.municipioId_'. $cidade),
                'inCodRedeEnsino' => config('sed.redeEnsinoCod'),
            ]
        );
        if ($codEscola) {
            return collect($response->object()->outEscolas)->where('outCodEscola', $codEscola)->first();
        }

        return $response->collect();
    }
}
