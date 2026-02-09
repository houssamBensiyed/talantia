<?php

namespace Database\Factories;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobOffer>
 */
class JobOfferFactory extends Factory
{
    protected $model = JobOffer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Développeur Fullstack PHP/Laravel',
            'Développeur Frontend React',
            'Développeur Backend Node.js',
            'DevOps Engineer',
            'Data Scientist',
            'Product Manager',
            'UX/UI Designer Senior',
            'Chef de Projet IT',
            'Ingénieur Cloud AWS',
            'Consultant SAP',
            'Analyste Business Intelligence',
            'Lead Developer Python',
            'Architecte Solution',
            'Scrum Master',
            'QA Engineer',
        ];

        $specialties = ['Tech', 'Finance', 'Marketing', 'Design', 'Engineering', 'Sales', 'HR', 'Legal'];

        $locations = ['Paris', 'Lyon', 'Marseille', 'Toulouse', 'Bordeaux', 'Nantes', 'Lille', 'Remote'];

        $jobImages = [
            'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=400&fit=crop',
            'https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=800&h=400&fit=crop',
            'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800&h=400&fit=crop',
            'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=400&fit=crop',
            'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=800&h=400&fit=crop',
        ];

        return [
            'user_id' => User::factory()->recruiter(),
            'title' => fake()->randomElement($titles),
            'description' => fake()->paragraphs(3, true),
            'company' => fake()->company(),
            'contract_type' => fake()->randomElement(['CDI', 'CDD', 'Full-time', 'Stage', 'Freelance']),
            'image' => fake()->randomElement($jobImages),
            'specialty' => fake()->randomElement($specialties),
            'location' => fake()->randomElement($locations),
            'is_closed' => false,
        ];
    }

    /**
     * Indicate that the job offer is closed.
     */
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_closed' => true,
        ]);
    }
}
