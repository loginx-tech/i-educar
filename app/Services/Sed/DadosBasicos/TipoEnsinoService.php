<?php

namespace App\Services\Sed\DadosBasicos;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class TipoEnsinoService
{
    /**
     * Inserindo a descrição do tipo de ensino para nomear as turmas (O sed só retorna o código do tipo de ensino).
     *
     * @param array $turmas
     */
    public static function mapDescricao($turmas, $tiposEnsino)
    {
        $turmas = collect($turmas)->map(function ($turma) use ($tiposEnsino) {
            $tipoEnsino      = collect($tiposEnsino)->firstWhere('outCodTipoEnsino', $turma['outCodTipoEnsino']);
            $outDescSerieAno = collect($tipoEnsino['outSerieAno'])->firstWhere('outCodSerieAno', $turma['outCodSerieAno']);
            if(!$outDescSerieAno) return $turma;
            $turma['outDescSerieAno'] = $outDescSerieAno['outDescSerieAno'] ?? 'nao foi';

            return $turma;
        });
        return $turmas;
    }
}
