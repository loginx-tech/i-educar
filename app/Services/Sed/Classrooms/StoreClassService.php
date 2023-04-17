<?php

namespace App\Services\Sed\Classrooms;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class StoreClassService extends SedAuthService
{
    /**
     * Cria a ficha do aluno no SED, retorna o RA
     *
     */
    public function __invoke($class)
    {
        $response = parent::post(
            SedRouters::STORE_SALA->value,
            [
                "inAnoLetivo" => $class->inAnoLetivo ?? null,
                "inNumClasse" => $class->inNumClasse ?? null,
                "inCodEscola" => $class->inCodEscola ?? null,
                "inCodUnidade" => $class->inCodUnidade ?? null,
                "inCodTipoEnsino" => $class->inCodTipoEnsino ?? null,
                "inCodSerieAno" => $class->inCodSerieAno ?? null,
                "inCodTipoClasse" => $class->inCodTipoClasse ?? null,
                "inCodTurno" => $class->inCodTurno ?? null,
                "inTurma" => $class->inTurma ?? null,
                "inNrCapacidadeFisicaMaxima" => $class->inNrCapacidadeFisicaMaxima ?? null,
                "inDataInicioAula" => $class->inDataInicioAula ?? null,
                "inDataFimAula" => $class->inDataFimAula ?? null,
                "inHorarioInicioAula" => $class->inHorarioInicioAula ?? null,
                "inHorarioFimAula" => $class->inHorarioFimAula ?? null,
                "inCodDuracao" => $class->inCodDuracao ?? null,
                "inCodHabilitacao" => $class->inCodHabilitacao ?? null,
                "inDiasDaSemana" => $class->inDiasDaSemana ?? [
                    "inFlagSegunda" => $class->inHoraIniAulaSegunda ? 1 : null,
                    "inHoraIniAulaSegunda" => $class->inHoraIniAulaSegunda ?? null,
                    "inHoraFimAulaSegunda" => $class->inHoraFimAulaSegunda ?? null,
                    "inFlagTerca" => $class->inHoraIniAulaTerca ? 2 : null,
                    "inHoraIniAulaTerca" => $class->inHoraIniAulaTerca ?? null,
                    "inHoraFimAulaTerca" => $class->inHoraFimAulaTerca ?? null,
                    "inFlagQuarta" => $class->inHoraIniAulaQuarta ? 3 : null,
                    "inHoraIniAulaQuarta" => $class->inHoraIniAulaQuarta ?? null,
                    "inHoraFimAulaQuarta" => $class->inHoraFimAulaQuarta ?? null,
                    "inFlagQuinta" => $class->inHoraIniAulaQuinta ? 4 : null,
                    "inHoraIniAulaQuinta" => $class->inHoraIniAulaQuinta ?? null,
                    "inHoraFimAulaQuinta" => $class->inHoraFimAulaQuinta ?? null,
                    "inFlagSexta" => $class->inHoraIniAulaSexta ? 5 : null,
                    "inHoraIniAulaSexta" => $class->inHoraIniAulaSexta ?? null,
                    "inHoraFimAulaSexta" => $class->inHoraFimAulaSexta ?? null,
                    "inFlagSabado" => $class->inHoraIniAulaSabado ? 6 : null,
                    "inHoraIniAulaSabado" => $class->inHoraIniAulaSabado ?? null,
                    "inHoraFimAulaSabado" => $class->inHoraFimAulaSabado ?? null,
                ],
                // "inCodigoAtividadeComplementar" => [
                //     ,
                //     ,
                //     ,
                //     ,
                // ],
                "inNumeroSala" => $class->inNumeroSala ?? null,
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

