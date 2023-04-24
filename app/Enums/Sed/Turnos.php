<?php

namespace App\Enums\Sed;

enum Turnos: int
{
    case MANHA               = 1;
    case INTERMEDIARIO       = 2;
    case TARDE               = 3;
    case VESPERTINO          = 4;
    case NOITE               = 5;
    case INTEGRAL            = 6;

    public function getString(): string
    {
        switch ($this->value) {
            case self::MANHA->value:          return 'Manhã';
                
                // no break
            case self::INTERMEDIARIO->value:  return 'Intermediario';
            case self::TARDE->value:          return 'Tarde';
            case self::VESPERTINO->value:     return 'Vespertino';
            case self::NOITE->value:          return 'Noite';
            case self::INTEGRAL->value:       return 'Integral';
        }
    }
}
