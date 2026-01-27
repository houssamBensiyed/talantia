<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing users first
        User::truncate();

        // Create test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'user_type' => 'job_seeker',
            'company' => null,
            'specialty' => 'Tech',
            'bio' => 'A passionate developer looking for new opportunities.',
        ]);

        // Create featured recruiters with professional photos from randomuser.me
        $recruiters = [
            [
                'name' => 'Sophie Martin',
                'email' => 'sophie.martin@techcorp.fr',
                'company' => 'TechCorp',
                'specialty' => 'Tech',
                'bio' => 'Talantia a révolutionné notre processus de recrutement. Nous avons trouvé des talents exceptionnels!',
                'photo_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=600&fit=crop',
            ],
            [
                'name' => 'Alexandre Dubois',
                'email' => 'a.dubois@innovate.io',
                'company' => 'Innovate.io',
                'specialty' => 'Engineering',
                'bio' => 'La qualité des candidats sur Talantia est incomparable. Notre équipe s\'est agrandie de 15 ingénieurs.',
                'photo_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=600&fit=crop',
            ],
            [
                'name' => 'Marie Lambert',
                'email' => 'marie@designstudio.fr',
                'company' => 'Design Studio',
                'specialty' => 'Design',
                'bio' => 'Une plateforme élégante et efficace. Les designers recrutés sont vraiment au top niveau.',
                'photo_url' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=600&fit=crop',
            ],
            [
                'name' => 'Thomas Bernard',
                'email' => 'thomas.b@financeplus.com',
                'company' => 'Finance Plus',
                'specialty' => 'Finance',
                'bio' => 'Talantia comprend les besoins du secteur financier. Le matching est précis et efficace.',
                'photo_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=600&fit=crop',
            ],
            [
                'name' => 'Julie Rousseau',
                'email' => 'julie.r@startuplab.co',
                'company' => 'StartupLab',
                'specialty' => 'Marketing',
                'bio' => 'En tant que startup, chaque recrutement compte. Talantia nous a permis de constituer une équipe de rêve.',
                'photo_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=600&fit=crop',
            ],
            [
                'name' => 'Pierre Moreau',
                'email' => 'pierre@globaltech.fr',
                'company' => 'GlobalTech',
                'specialty' => 'Tech',
                'bio' => 'Le réseau de talents tech sur Talantia est impressionnant. Nous recommandons cette plateforme.',
                'photo_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=600&fit=crop',
            ],
        ];

        foreach ($recruiters as $recruiter) {
            User::create([
                'name' => $recruiter['name'],
                'email' => $recruiter['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'user_type' => 'recruiter',
                'company' => $recruiter['company'],
                'specialty' => $recruiter['specialty'],
                'bio' => $recruiter['bio'],
                'photo' => $recruiter['photo_url'], // Store the external URL directly
            ]);
        }

        // Create additional random job seekers
        User::factory()->count(10)->create([
            'user_type' => 'job_seeker',
        ]);
    }
}
