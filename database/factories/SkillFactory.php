<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $skills = [
            'PHP', 'Laravel', 'JavaScript', 'TypeScript', 'Vue.js', 'React',
            'Angular', 'Node.js', 'Python', 'Django', 'Java', 'Spring Boot',
            'C#', '.NET', 'SQL', 'MySQL', 'PostgreSQL', 'MongoDB',
            'Git', 'Docker', 'Kubernetes', 'AWS', 'Azure', 'GCP',
            'Agile', 'Scrum', 'Jira', 'CI/CD', 'REST API', 'GraphQL',
            'HTML', 'CSS', 'Tailwind CSS', 'Bootstrap', 'Figma', 'Adobe XD',
            'Excel', 'Power BI', 'Tableau', 'Machine Learning', 'Deep Learning',
            'Anglais', 'Français', 'Allemand', 'Espagnol', 'Communication',
            'Leadership', 'Gestion de Projet', 'Travail d\'équipe',
        ];

        return [
            'name' => fake()->unique()->randomElement($skills),
        ];
    }
}
