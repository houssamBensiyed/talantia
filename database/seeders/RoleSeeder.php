<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Job Offer permissions
            'create job offers',
            'edit job offers',
            'delete job offers',
            'close job offers',
            'view job applications',
            
            // Job Application permissions
            'apply to jobs',
            'view own applications',
            
            // Candidate Profile permissions
            'manage candidate profile',
            
            // Friendship permissions
            'send friend requests',
            'manage friendships',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Recruiter role
        $recruiterRole = Role::firstOrCreate(['name' => 'recruiter']);
        $recruiterRole->givePermissionTo([
            'create job offers',
            'edit job offers',
            'delete job offers',
            'close job offers',
            'view job applications',
            'send friend requests',
            'manage friendships',
        ]);

        // Create Job Seeker role
        $jobSeekerRole = Role::firstOrCreate(['name' => 'job_seeker']);
        $jobSeekerRole->givePermissionTo([
            'apply to jobs',
            'view own applications',
            'manage candidate profile',
            'send friend requests',
            'manage friendships',
        ]);
    }
}
