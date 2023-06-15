<?php

namespace App\Enums\Sed\Transferencia;

enum TipoTransferenciaEnum: int
{
    // Retorna um codigo caso queria manupular o valor fora das funções do enum Ex. 000

    // Primeiro digito: 1 - Inscrição de Alunos por Transferência, 8 - Inscrição de Alunos por Deslocamento, 9 - Inscrição por Intenção de Transferência
    // Segundo digito: 0 - Ensino Fundamental, 1 - Ensino Médio
    // Terceiro digito: O proprio codigo do motivo vindo do SED
    // Se houver apenas 2 digitos ele é tanto para medio quanto fundamental entao não conta o digito dois.

    case TRANSFERENCIA_FUND_MUDANCA   = 001;
    case TRANSFERENCIA_FUND_TRABALHO  = 002;
    case TRANSFERENCIA_FUND_FAMILIA   = 003;

    case TRANSFERENCIA_MEDIO_MUDANCA   = 011;
    case TRANSFERENCIA_MEDIO_TRABALHO  = 012;

    case DESLOCAMENTO_FUND_MUDANCA     = 801;
    case DESLOCAMENTO_FUND_TRABALHO    = 802;
    case DESLOCAMENTO_FUND_FAMILIA     = 803;

    case DESLOCAMENTO_MEDIO_MUDANCA    = 811;
    case DESLOCAMENTO_MEDIO_TRABALHO   = 812;
    case DESLOCAMENTO_MEDIO_INTERESSE  = 814;

    case INTENCAO_INTERESSE            = 94;

    public function toString(): string
    {
        switch ($this->value) {
            case self::TRANSFERENCIA->value:   return 'INSCRIÇÃO DE ALUNOS POR TRANSFERÊNCIA';
                // no break
            case self::DESLOCAMENTO->value:    return 'INSCRIÇÃO DE ALUNOS POR DESLOCAMENTO';
            case self::INTENCAO->value:        return 'INSCRIÇÃO POR INTENÇÃO DE TRANSFERÊNCIA';
        }
    }
}
