<?php

namespace Database\Factories;

use App\Models\Vaccination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vaccination>
 */
class VaccinationFactory extends Factory
{
    protected $model = Vaccination::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'vaccine_center_id' => \App\Models\VaccineCenter::factory(),
            'scheduled_date' => null,
            'status' => 'Not scheduled',
        ];
    }
}
