<?php

namespace Database\Factories;

use App\Models\VaccineCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VaccineCenter>
 */
class VaccineCenterFactory extends Factory
{
    protected $model = VaccineCenter::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'daily_limit' => $this->faker->numberBetween(50, 200),
        ];
    }
}
