<?php

namespace App\Enums;

enum SedCorRacas: int
{
    case BRANCA         = 1;
    case PRETA          = 2;
    case PARDA          = 3;
    case AMARELA        = 4;
    case INDIGENA       = 5;
    case NAO_DECLARADA  = 6;

    public static function getString(int $cor_raca): string
    {
        switch ($cor_raca) {
            case self::BRANCA->value:        return 'Branca';
            case self::PRETA->value:         return 'Preta';
            case self::PARDA->value:         return 'Parda';
            case self::AMARELA->value:       return 'Amarela';
            case self::INDIGENA->value:      return 'Indígena';
            case self::NAO_DECLARADA->value: return 'Não declarada';
        }
    }
}
