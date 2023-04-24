<?php

namespace App\Enums;

enum SedNacionalidades: int
{
    case BRASILEIRO           = 1;
    case ESTRANGEIRO          = 2;
    case BRASILEIRO_EXTERIOR  = 3;

    public static function getString(int $nacionalidade): string
    {
        switch ($nacionalidade) {
            case self::BRASILEIRO->value:          return 'Brasileiro';

                
                // no break
            case self::ESTRANGEIRO->value:         return 'Estrangeiro';
            case self::BRASILEIRO_EXTERIOR->value: return 'Brasileiro Nascido no Exterior';
        }
    }
}
