<?php

namespace App\Enums\Sed\Transferencia;

enum TipoTransferenciaEnum: int
{
    case TRANSFERENCIA   = 100; // Aqui o value final é 0, porem é complexo manipular inputs com valor 0. Na função store o valor é convertido
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
