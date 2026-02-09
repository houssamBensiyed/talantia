<?php

namespace Database\Factories;

use App\Models\CandidateProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CandidateProfile>
 */
class CandidateProfileFactory extends Factory
{
    protected $model = CandidateProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Développeur Fullstack',
            'Développeur Frontend',
            'Développeur Backend',
            'Data Scientist',
            'DevOps Engineer',
            'Product Manager',
            'UX/UI Designer',
            'Comptable Senior',
            'Chef de Projet IT',
            'Ingénieur Logiciel',
            'Analyste Business',
            'Consultant IT',
            'Architecte Solution',
            'Responsable Marketing Digital',
        ];

        return [
            'user_id' => User::factory()->jobSeeker(),
            'title' => fake()->randomElement($titles),
        ];
    }
}
