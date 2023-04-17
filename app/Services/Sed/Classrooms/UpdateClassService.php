<?php

namespace App\Services\Sed\Classrooms;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class UpdateClassService extends SedAuthService
{
    /**
     * Cria a ficha do aluno no SED, retorna o RA
     *
     */
    public function __invoke($class)
    {
        $response = parent::post(
            SedRouters::UPDATE_SALA->value,
            [
                'inAnoLetivo' => $class->inAnoLetivo ?? null,
                'inNumClasse' => $class->inNumClasse ?? null,
                'inCodEscola' => $class->inCodEscola ?? null,
                'inCodTipoEnsino' => $class->inCodTipoEnsino ?? null,
                'inCodSerieAno' => $class->inCodSerieAno ?? null,
                'inCodTipoClasse' => $class->inCodTipoClasse ?? null,
                'inCodTurno' => $class->inCodTurno ?? null,
                'inTurma' => $class->inTurma ?? null,
                'inNrCapacidadeFisicaMaxima' => $class->inNrCapacidadeFisicaMaxima ?? null,
                'inDataInicioAula' => $class->inDataInicioAula ?? null,
                'inDataFimAula' => $class->inDataFimAula ?? null,
                'inHorarioInicioAula' => $class->inHorarioInicioAula ?? null,
                'inHorarioFimAula' => $class->inHorarioFimAula ?? null,
                'inCodDuracao' => $class->inCodDuracao ?? null,
                'inCodHabilitacao' => $class->inCodHabilitacao ?? null,
                // "inCodigoAtividadeComplementar" => [
                //     ,
                //     ,
                //     ,
                //     ,
                // ],
                'inNumeroSala' => $class->inNumeroSala ?? null,
                // "inDiasSemana" => [
                //     "inFlagSegunda" => ,
                //     "inHoraIniAulaSegunda" => ,
                //     "inHoraFimAulaSegunda" => ,
                //     "inFlagTerca" => ,
                //     "inHoraIniAulaTerca" => ,
                //     "inHoraFimAulaTerca" => ,
                //     "inFlagQuarta" => ,
                //     "inHoraIniAulaQuarta" => ,
                //     "inHoraFimAulaQuarta" => ,
                //     "inFlagQuinta" => ,
                //     "inHoraIniAulaQuinta" => ,
                //     "inHoraFimAulaQuinta" => ,
                //     "inFlagSexta" => ,
                //     "inHoraIniAulaSexta" => ,
                //     "inHoraFimAulaSexta" =>
                // ]
            ]
        );

        return $response;
    }
}
