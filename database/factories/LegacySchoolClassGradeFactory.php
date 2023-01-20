<?php

namespace Database\Factories;

use App\Models\LegacySchoolClassGrade;
use Illuminate\Database\Eloquent\Factories\Factory;

class LegacySchoolClassGradeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LegacySchoolClassGrade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $schoolGrade = LegacySchoolGradeFactory::new()->create();

        return [
            'escola_id' => $schoolGrade->school_id,
            'serie_id'  => $schoolGrade->grade_id,
            'turma_id'  => LegacySchoolClassFactory::new()->create(),
            'boletim_id' => $this->faker->randomDigitNotZero(),
            'boletim_diferenciado_id' => $this->faker->randomDigitNotZero(),
        ];
    }
}
