<?php

namespace App\Services\Reports;

use Illuminate\Support\Collection;

class Util
{
    public static function format(mixed $value, int $decimalPlaces = 1): string
    {
        return number_format($value, $decimalPlaces, ',', '.');
    }

    public static function float(mixed $value): float
    {
        return str_replace(',', '.', $value);
    }

    public static function moduleName(Collection|null $modules = null): array
    {
        if ($modules === null) {
            return [
                [
                    'step' => 'An',
                    'name' => 'ANUAL'
                ]
            ];
        }

        return $modules->map(static fn ($module) => match ($modules->count()) {
            1 => [
                'step' => $module,
                'name' => 'ANUAL',
                'abbreviation' => 'ANUAL',
            ],
            2 => [
                'step' => $module,
                'name' => "{$module}° SEMESTRE",
                'abbreviation' => "{$module}° SEM.",
            ],
            3 => [
                'step' => $module,
                'name' => "{$module}° TRIMESTRE",
                'abbreviation' => "{$module}° TRIM.",
            ],
            4 => [
                'step' => $module,
                'name' => "{$module}° BIMESTRE",
                'abbreviation' => "{$module}° BIM.",
            ],
            default => [],
        })->toArray();
    }
}
