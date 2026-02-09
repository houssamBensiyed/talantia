<?php

namespace Database\Seeders;

use App\Models\CandidateProfile;
use App\Models\Experience;
use App\Models\Formation;
use App\Models\Friendship;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run RoleSeeder first to create roles and permissions
        $this->call(RoleSeeder::class);

        // Create skills first (they are reused)
        $skillNames = [
            'PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'Node.js',
            'Python', 'Django', 'Java', 'Spring Boot', 'SQL', 'MySQL',
            'PostgreSQL', 'MongoDB', 'Git', 'Docker', 'AWS', 'Agile',
            'Scrum', 'REST API', 'GraphQL', 'HTML', 'CSS', 'Tailwind CSS',
            'Figma', 'Excel', 'Power BI', 'Machine Learning', 'Anglais',
            'Français', 'Leadership', 'Gestion de Projet',
        ];

        $skills = collect($skillNames)->map(function ($name) {
            return Skill::create(['name' => $name]);
        });

        // =============================================
        // CREATE TEST USERS
        // =============================================

        // Test Job Seeker
        $testJobSeeker = User::create([
            'name' => 'Jean Dupont',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'user_type' => 'job_seeker',
            'specialty' => 'Tech',
            'bio' => 'Développeur passionné avec 5 ans d\'expérience en développement web.',
        ]);
        $testJobSeeker->assignRole('job_seeker');

        // Create candidate profile for test job seeker
        $testProfile = CandidateProfile::create([
            'user_id' => $testJobSeeker->id,
            'title' => 'Développeur Fullstack PHP/Laravel',
        ]);

        // Add formations
        Formation::create([
            'candidate_profile_id' => $testProfile->id,
            'diploma' => 'Master Informatique',
            'school' => 'Université Paris-Saclay',
            'graduation_year' => 2020,
        ]);

        // Add experiences
        Experience::create([
            'candidate_profile_id' => $testProfile->id,
            'position' => 'Développeur Fullstack',
            'company' => 'TechCorp',
            'start_date' => '2020-09-01',
            'end_date' => null,
            'description' => 'Développement d\'applications web avec Laravel et Vue.js.',
        ]);

        // Add skills
        $testProfile->skills()->attach($skills->whereIn('name', ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'MySQL', 'Git'])->pluck('id'));

        // =============================================
        // CREATE RECRUITERS
        // =============================================

        $recruiters = [
            [
                'name' => 'Sophie Martin',
                'email' => 'sophie.martin@techcorp.fr',
                'company' => 'TechCorp',
                'specialty' => 'Tech',
                'bio' => 'Talantia a révolutionné notre processus de recrutement. Nous avons trouvé des talents exceptionnels!',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=600&fit=crop',
            ],
            [
                'name' => 'Alexandre Dubois',
                'email' => 'a.dubois@innovate.io',
                'company' => 'Innovate.io',
                'specialty' => 'Engineering',
                'bio' => 'La qualité des candidats sur Talantia est incomparable. Notre équipe s\'est agrandie de 15 ingénieurs.',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=600&fit=crop',
            ],
            [
                'name' => 'Marie Lambert',
                'email' => 'marie@designstudio.fr',
                'company' => 'Design Studio',
                'specialty' => 'Design',
                'bio' => 'Une plateforme élégante et efficace. Les designers recrutés sont vraiment au top niveau.',
                'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=600&fit=crop',
            ],
            [
                'name' => 'Thomas Bernard',
                'email' => 'thomas.b@financeplus.com',
                'company' => 'Finance Plus',
                'specialty' => 'Finance',
                'bio' => 'Talantia comprend les besoins du secteur financier. Le matching est précis et efficace.',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=600&fit=crop',
            ],
        ];

        $createdRecruiters = [];
        foreach ($recruiters as $recruiter) {
            $user = User::create([
                'name' => $recruiter['name'],
                'email' => $recruiter['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'user_type' => 'recruiter',
                'company' => $recruiter['company'],
                'specialty' => $recruiter['specialty'],
                'bio' => $recruiter['bio'],
                'photo' => $recruiter['photo'],
            ]);
            $user->assignRole('recruiter');
            $createdRecruiters[] = $user;
        }

        // =============================================
        // CREATE JOB OFFERS
        // =============================================

        $jobOffers = [
            [
                'title' => 'Développeur Fullstack PHP/Laravel',
                'description' => "Nous recherchons un développeur fullstack expérimenté pour rejoindre notre équipe dynamique.\n\nMissions:\n- Développer des applications web avec Laravel\n- Créer des interfaces utilisateur avec Vue.js\n- Participer aux code reviews\n- Contribuer à l'amélioration continue\n\nProfil recherché:\n- 3+ ans d'expérience en PHP/Laravel\n- Maîtrise de JavaScript et Vue.js\n- Connaissance de MySQL et Git",
                'company' => 'TechCorp',
                'contract_type' => 'CDI',
                'specialty' => 'Tech',
                'location' => 'Paris',
                'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=400&fit=crop',
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => "Rejoignez notre équipe infrastructure pour gérer nos environnements cloud.\n\nMissions:\n- Gérer l'infrastructure AWS\n- Mettre en place des pipelines CI/CD\n- Automatiser les déploiements\n- Monitorer les applications\n\nProfil recherché:\n- Expérience avec Docker et Kubernetes\n- Connaissance d'AWS ou Azure\n- Scripting (Bash, Python)",
                'company' => 'Innovate.io',
                'contract_type' => 'CDI',
                'specialty' => 'Engineering',
                'location' => 'Lyon',
                'image' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800&h=400&fit=crop',
            ],
            [
                'title' => 'UX/UI Designer Senior',
                'description' => "Nous cherchons un designer créatif pour améliorer l'expérience utilisateur de nos produits.\n\nMissions:\n- Créer des wireframes et prototypes\n- Réaliser des tests utilisateurs\n- Collaborer avec les développeurs\n- Définir notre design system\n\nProfil recherché:\n- 5+ ans d'expérience en design\n- Maîtrise de Figma\n- Portfolio solide",
                'company' => 'Design Studio',
                'contract_type' => 'CDI',
                'specialty' => 'Design',
                'location' => 'Paris',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&h=400&fit=crop',
            ],
            [
                'title' => 'Stage - Développeur Frontend',
                'description' => "Stage de 6 mois pour un étudiant passionné par le développement web.\n\nMissions:\n- Développer des composants React\n- Intégrer des maquettes Figma\n- Participer aux sprints\n\nProfil recherché:\n- Étudiant en informatique\n- Connaissances en JavaScript/React\n- Motivation et curiosité",
                'company' => 'TechCorp',
                'contract_type' => 'Stage',
                'specialty' => 'Tech',
                'location' => 'Remote',
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=400&fit=crop',
            ],
            [
                'title' => 'Data Analyst',
                'description' => "Rejoignez notre équipe data pour analyser les données financières.\n\nMissions:\n- Créer des dashboards Power BI\n- Analyser les données clients\n- Automatiser les reportings\n\nProfil recherché:\n- 2+ ans en analyse de données\n- Maîtrise de SQL et Excel\n- Connaissance de Power BI",
                'company' => 'Finance Plus',
                'contract_type' => 'CDD',
                'specialty' => 'Finance',
                'location' => 'Bordeaux',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=400&fit=crop',
            ],
        ];

        $createdJobOffers = [];
        foreach ($jobOffers as $index => $offer) {
            $recruiter = $createdRecruiters[$index % count($createdRecruiters)];
            $createdJobOffers[] = JobOffer::create([
                'user_id' => $recruiter->id,
                'title' => $offer['title'],
                'description' => $offer['description'],
                'company' => $offer['company'],
                'contract_type' => $offer['contract_type'],
                'specialty' => $offer['specialty'],
                'location' => $offer['location'],
                'image' => $offer['image'],
                'is_closed' => false,
            ]);
        }

        // Add 50 more job offers using factory for lazy loading testing
        $additionalJobs = JobOffer::factory()->count(50)->create([
            'user_id' => $createdRecruiters[array_rand($createdRecruiters)]->id,
            'is_closed' => false,
        ]);

        foreach ($additionalJobs as $job) {
            $createdJobOffers[] = $job;
        }

        // =============================================
        // CREATE ADDITIONAL JOB SEEKERS
        // =============================================

        $jobSeekerData = [
            ['name' => 'Pierre Moreau', 'specialty' => 'Tech', 'title' => 'Développeur Backend Python'],
            ['name' => 'Camille Leroy', 'specialty' => 'Design', 'title' => 'UX Designer'],
            ['name' => 'Lucas Martin', 'specialty' => 'Finance', 'title' => 'Comptable Junior'],
            ['name' => 'Emma Bernard', 'specialty' => 'Marketing', 'title' => 'Chef de Projet Digital'],
            ['name' => 'Hugo Petit', 'specialty' => 'Tech', 'title' => 'DevOps Junior'],
        ];

        $createdJobSeekers = [$testJobSeeker];
        foreach ($jobSeekerData as $data) {
            $user = User::factory()->jobSeeker()->create([
                'name' => $data['name'],
                'specialty' => $data['specialty'],
            ]);
            $user->assignRole('job_seeker');

            // Create candidate profile
            $profile = CandidateProfile::create([
                'user_id' => $user->id,
                'title' => $data['title'],
            ]);

            // Add random formations and experiences
            Formation::factory()->count(rand(1, 2))->create(['candidate_profile_id' => $profile->id]);
            Experience::factory()->count(rand(1, 3))->create(['candidate_profile_id' => $profile->id]);

            // Add random skills
            $profile->skills()->attach($skills->random(rand(3, 6))->pluck('id'));

            $createdJobSeekers[] = $user;
        }

        // =============================================
        // CREATE JOB APPLICATIONS
        // =============================================

        // Test job seeker applies to first 2 jobs
        JobApplication::create([
            'user_id' => $testJobSeeker->id,
            'job_offer_id' => $createdJobOffers[0]->id,
            'status' => 'pending',
            'cover_letter' => 'Je suis très intéressé par ce poste qui correspond parfaitement à mon profil.',
        ]);

        JobApplication::create([
            'user_id' => $testJobSeeker->id,
            'job_offer_id' => $createdJobOffers[1]->id,
            'status' => 'reviewed',
            'cover_letter' => 'Mon expérience en développement me permettrait de contribuer efficacement à votre équipe.',
        ]);

        // Other job seekers apply randomly
        foreach ($createdJobSeekers as $jobSeeker) {
            if ($jobSeeker->id === $testJobSeeker->id) continue;
            
            $randomJobs = collect($createdJobOffers)->random(rand(1, 3));
            foreach ($randomJobs as $job) {
                JobApplication::create([
                    'user_id' => $jobSeeker->id,
                    'job_offer_id' => $job->id,
                    'status' => fake()->randomElement(['pending', 'reviewed']),
                    'cover_letter' => fake()->optional(0.7)->paragraph(),
                ]);
            }
        }

        // =============================================
        // CREATE FRIENDSHIPS
        // =============================================

        // Test job seeker has some friends
        Friendship::create([
            'sender_id' => $testJobSeeker->id,
            'receiver_id' => $createdJobSeekers[1]->id,
            'status' => 'accepted',
        ]);

        Friendship::create([
            'sender_id' => $createdJobSeekers[2]->id,
            'receiver_id' => $testJobSeeker->id,
            'status' => 'pending',
        ]);

        // Add one closed job offer for testing
        JobOffer::create([
            'user_id' => $createdRecruiters[0]->id,
            'title' => 'Développeur Junior (Poste Pourvu)',
            'description' => 'Ce poste a été pourvu. Merci à tous les candidats.',
            'company' => 'TechCorp',
            'contract_type' => 'CDI',
            'specialty' => 'Tech',
            'location' => 'Paris',
            'image' => 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=800&h=400&fit=crop',
            'is_closed' => true,
        ]);
    }
}
