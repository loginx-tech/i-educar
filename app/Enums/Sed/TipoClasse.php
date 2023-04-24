<?php

namespace App\Enums\Sed;

enum TipoEnsino: int
{
    case ACELERAÇÃO                         = 3;
    case ALTO_RENDIMENTO_ESPORTIVO          = 33;
    case EJA_FUNDAMENTAL_ANOS_FINAIS        = 26;
    case EJA_ENSINO_MEDIO                   = 5;
    case EDUCACAO_INFANTIL                  = 6;

    // TO-DO: Add all types

    public function getString(): string
    {
        switch ($this->value) {
            case self::ENSINO_MEDIO->value:                     return 'ENSINO MEDIO';
                
                // no break
            case self::EJA_FUNDAMENTAL_ANOS_INICIAIS->value:    return 'EJA FUNDAMENTAL - ANOS INICIAIS';
            case self::EJA_FUNDAMENTAL_ANOS_FINAIS->value:      return 'EJA FUNDAMENTAL - ANOS FINAIS';
            case self::EJA_ENSINO_MEDIO->value:                 return 'EJA ENSINO MEDIO';
            case self::EDUCACAO_INFANTIL->value:                return 'EDUCACAO INFANTIL';
        }
    }
}
