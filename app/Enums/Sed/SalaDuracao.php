<?php

namespace App\Enums\Sed;

enum SalaDuracao: int
{
    case ANUAL                   = 0;
    case PRIMEIRO_SEMESTRE       = 1;
    case SEGUNDO_SEMESTRE        = 2;

    // TO-DO: Add all types

    public function getString(): string
    {
        switch ($this->value) {
            case self::ANUAL->value:                return 'Anual';
            // no break
            case self::PRIMEIRO_SEMESTRE->value:    return 'Primeiro Semestre';
            case self::SEGUNDO_SEMESTRE->value:     return 'Segundo Semestre';
        }
    }
}
