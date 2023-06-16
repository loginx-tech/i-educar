<?php

namespace App\Enums\Sed\Transferencia;

enum TipoTransferenciaEnum: int
{
    case TRANSFERENCIA   = 0;
    case DESLOCAMENTO    = 8;
    case INTENCAO        = 9;

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
