<?php

namespace Tests\Feature;

use App\Models\CandidateProfile;
use App\Models\Experience;
use App\Models\Formation;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CandidateProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles and permissions
        $recruiterRole = Role::create(['name' => 'recruiter']);
        $jobSeekerRole = Role::create(['name' => 'job_seeker']);
        
        Permission::create(['name' => 'create job offers']);
        Permission::create(['name' => 'manage job offers']);
        Permission::create(['name' => 'view applications']);
        Permission::create(['name' => 'apply to jobs']);
        Permission::create(['name' => 'manage candidate profile']);
        
        $recruiterRole->givePermissionTo(['create job offers', 'manage job offers', 'view applications']);
        $jobSeekerRole->givePermissionTo(['apply to jobs', 'manage candidate profile']);
    }

    protected function createJobSeeker(): User
    {
        $user = User::factory()->jobSeeker()->create();
        $user->assignRole('job_seeker');
        return $user;
    }

    protected function createRecruiter(): User
    {
        $user = User::factory()->recruiter()->create();
        $user->assignRole('recruiter');
        return $user;
    }

    public function test_job_seekers_can_view_their_profile(): void
    {
        $jobSeeker = $this->createJobSeeker();

        $response = $this->actingAs($jobSeeker)->get(route('candidate.profile.index'));
        
        $response->assertOk();
        $response->assertViewIs('candidate.profile.index');
    }

    public function test_recruiters_cannot_view_candidate_profile_page(): void
    {
        $recruiter = $this->createRecruiter();

        $response = $this->actingAs($recruiter)->get(route('candidate.profile.index'));
        
        $response->assertForbidden();
    }

    public function test_job_seekers_can_access_edit_profile_page(): void
    {
        $jobSeeker = $this->createJobSeeker();

        $response = $this->actingAs($jobSeeker)->get(route('candidate.profile.edit'));
        
        $response->assertOk();
        $response->assertViewIs('candidate.profile.edit');
    }

    public function test_job_seekers_can_create_their_profile(): void
    {
        $jobSeeker = $this->createJobSeeker();

        $response = $this->actingAs($jobSeeker)->put(route('candidate.profile.update'), [
            'title' => 'Senior Developer',
        ]);
        
        $response->assertRedirect(route('candidate.profile.index'));
        $this->assertDatabaseHas('candidate_profiles', [
            'user_id' => $jobSeeker->id,
            'title' => 'Senior Developer',
        ]);
    }

    public function test_job_seekers_can_update_their_profile(): void
    {
        $jobSeeker = $this->createJobSeeker();
        CandidateProfile::create([
            'user_id' => $jobSeeker->id,
            'title' => 'Old Title',
        ]);

        $response = $this->actingAs($jobSeeker)->put(route('candidate.profile.update'), [
            'title' => 'Updated Title',
        ]);
        
        $response->assertRedirect(route('candidate.profile.index'));
        $this->assertDatabaseHas('candidate_profiles', [
            'user_id' => $jobSeeker->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_job_seekers_can_add_formations(): void
    {
        $jobSeeker = $this->createJobSeeker();
        $profile = CandidateProfile::create([
            'user_id' => $jobSeeker->id,
            'title' => 'Developer',
        ]);

        $response = $this->actingAs($jobSeeker)->post(route('candidate.formations.store'), [
            'diploma' => 'Master en Informatique',
            'school' => 'Université Paris-Saclay',
            'graduation_year' => 2024,
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('formations', [
            'candidate_profile_id' => $profile->id,
            'diploma' => 'Master en Informatique',
        ]);
    }

    public function test_job_seekers_can_delete_their_formations(): void
    {
        $jobSeeker = $this->createJobSeeker();
        $profile = CandidateProfile::create([
            'user_id' => $jobSeeker->id,
            'title' => 'Developer',
        ]);
        $formation = Formation::create([
            'candidate_profile_id' => $profile->id,
            'diploma' => 'Master',
            'school' => 'University',
            'graduation_year' => 2020,
        ]);

        $response = $this->actingAs($jobSeeker)->delete(route('candidate.formations.destroy', $formation));
        
        $response->assertRedirect();
        $this->assertDatabaseMissing('formations', ['id' => $formation->id]);
    }

    public function test_job_seekers_can_add_experiences(): void
    {
        $jobSeeker = $this->createJobSeeker();
        $profile = CandidateProfile::create([
            'user_id' => $jobSeeker->id,
            'title' => 'Developer',
        ]);

        $response = $this->actingAs($jobSeeker)->post(route('candidate.experiences.store'), [
            'position' => 'Software Engineer',
            'company' => 'Google',
            'start_date' => '2022-01-01',
            'end_date' => '2024-01-01',
            'description' => 'Worked on search algorithms.',
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('experiences', [
            'candidate_profile_id' => $profile->id,
            'position' => 'Software Engineer',
            'company' => 'Google',
        ]);
    }

    public function test_job_seekers_can_delete_their_experiences(): void
    {
        $jobSeeker = $this->createJobSeeker();
        $profile = CandidateProfile::create([
            'user_id' => $jobSeeker->id,
            'title' => 'Developer',
        ]);
        $experience = Experience::create([
            'candidate_profile_id' => $profile->id,
            'position' => 'Engineer',
            'company' => 'Company',
            'start_date' => '2020-01-01',
        ]);

        $response = $this->actingAs($jobSeeker)->delete(route('candidate.experiences.destroy', $experience));
        
        $response->assertRedirect();
        $this->assertDatabaseMissing('experiences', ['id' => $experience->id]);
    }

    public function test_job_seekers_can_sync_skills(): void
    {
        $jobSeeker = $this->createJobSeeker();
        $profile = CandidateProfile::create([
            'user_id' => $jobSeeker->id,
            'title' => 'Developer',
        ]);
        
        $skill1 = Skill::create(['name' => 'PHP']);
        $skill2 = Skill::create(['name' => 'Laravel']);

        $response = $this->actingAs($jobSeeker)->post(route('candidate.skills.sync'), [
            'skills' => [$skill1->id, $skill2->id],
        ]);
        
        $response->assertRedirect();
        $this->assertTrue($profile->skills()->where('skill_id', $skill1->id)->exists());
        $this->assertTrue($profile->skills()->where('skill_id', $skill2->id)->exists());
    }

    public function test_job_seekers_can_add_new_skills(): void
    {
        $jobSeeker = $this->createJobSeeker();
        $profile = CandidateProfile::create([
            'user_id' => $jobSeeker->id,
            'title' => 'Developer',
        ]);

        $response = $this->actingAs($jobSeeker)->post(route('candidate.skills.sync'), [
            'skills' => [],
            'new_skill' => 'Vue.js',
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('skills', ['name' => 'Vue.js']);
        $this->assertTrue($profile->skills()->where('name', 'Vue.js')->exists());
    }

    public function test_users_cannot_delete_other_users_formations(): void
    {
        $jobSeeker1 = $this->createJobSeeker();
        $jobSeeker2 = $this->createJobSeeker();
        
        $profile = CandidateProfile::create([
            'user_id' => $jobSeeker1->id,
            'title' => 'Developer',
        ]);
        $formation = Formation::create([
            'candidate_profile_id' => $profile->id,
            'diploma' => 'Master',
            'school' => 'University',
            'graduation_year' => 2020,
        ]);

        $response = $this->actingAs($jobSeeker2)->delete(route('candidate.formations.destroy', $formation));
        
        $response->assertForbidden();
        $this->assertDatabaseHas('formations', ['id' => $formation->id]);
    }
}
