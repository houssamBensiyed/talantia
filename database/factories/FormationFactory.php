<?php

namespace Database\Factories;

use App\Models\CandidateProfile;
use App\Models\Formation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formation>
 */
class FormationFactory extends Factory
{
    protected $model = Formation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $diplomas = [
            'Licence Informatique',
            'Master Informatique',
            'Diplôme d\'Ingénieur',
            'BTS Informatique',
            'DUT Informatique',
            'Master Data Science',
            'MBA Management',
            'Master Commerce',
            'Licence Économie',
            'Master Finance',
        ];

        $schools = [
            'Université Paris-Saclay',
            'École Polytechnique',
            'HEC Paris',
            'ESSEC Business School',
            'CentraleSupélec',
            'Université Lyon 1',
            'INSA Lyon',
            'Université de Bordeaux',
            'École 42',
            'Epitech',
        ];

        return [
            'candidate_profile_id' => CandidateProfile::factory(),
            'diploma' => fake()->randomElement($diplomas),
            'school' => fake()->randomElement($schools),
            'graduation_year' => fake()->numberBetween(2015, 2024),
        ];
    }
}
