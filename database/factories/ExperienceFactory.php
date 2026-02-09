<?php

namespace Database\Factories;

use App\Models\CandidateProfile;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            'Développeur Web',
            'Développeur Mobile',
            'Chef de Projet',
            'Lead Developer',
            'Product Owner',
            'Scrum Master',
            'Analyste Fonctionnel',
            'Consultant Junior',
            'Ingénieur Logiciel',
            'Data Analyst',
        ];

        $startDate = fake()->dateTimeBetween('-5 years', '-1 year');
        $endDate = fake()->optional(0.7)->dateTimeBetween($startDate, 'now');

        return [
            'candidate_profile_id' => CandidateProfile::factory(),
            'position' => fake()->randomElement($positions),
            'company' => fake()->company(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'description' => fake()->optional(0.8)->paragraph(2),
        ];
    }

    /**
     * Indicate that this is a current position.
     */
    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => null,
        ]);
    }
}
