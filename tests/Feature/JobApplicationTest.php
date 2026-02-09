<?php

namespace Tests\Feature;

use App\Models\CandidateProfile;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class JobApplicationTest extends TestCase
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

    protected function createRecruiter(): User
    {
        $user = User::factory()->recruiter()->create();
        $user->assignRole('recruiter');
        return $user;
    }

    protected function createJobSeeker(): User
    {
        $user = User::factory()->jobSeeker()->create();
        $user->assignRole('job_seeker');
        return $user;
    }

    public function test_job_seekers_can_apply_to_open_jobs(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id, 'is_closed' => false]);
        $jobSeeker = $this->createJobSeeker();

        $response = $this->actingAs($jobSeeker)->post(route('jobs.apply', $job), [
            'cover_letter' => 'I am very interested in this position.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('job_applications', [
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);
    }

    public function test_job_seekers_cannot_apply_to_closed_jobs(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->closed()->create(['user_id' => $recruiter->id]);
        $jobSeeker = $this->createJobSeeker();

        $response = $this->actingAs($jobSeeker)->post(route('jobs.apply', $job), [
            'cover_letter' => 'I am very interested in this position.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('job_applications', [
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
        ]);
    }

    public function test_job_seekers_cannot_apply_twice_to_same_job(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id, 'is_closed' => false]);
        $jobSeeker = $this->createJobSeeker();

        // First application
        JobApplication::create([
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        // Try to apply again
        $response = $this->actingAs($jobSeeker)->post(route('jobs.apply', $job), [
            'cover_letter' => 'Second attempt.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        
        $this->assertEquals(1, JobApplication::where('user_id', $jobSeeker->id)
            ->where('job_offer_id', $job->id)
            ->count());
    }

    public function test_recruiters_cannot_apply_to_jobs(): void
    {
        $recruiter1 = $this->createRecruiter();
        $recruiter2 = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter1->id]);

        $response = $this->actingAs($recruiter2)->post(route('jobs.apply', $job));
        
        $response->assertForbidden();
    }

    public function test_job_seekers_can_view_their_applications(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        $jobSeeker = $this->createJobSeeker();
        
        JobApplication::create([
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($jobSeeker)->get(route('applications.my'));
        
        $response->assertOk();
        $response->assertViewIs('applications.my');
    }

    public function test_job_seekers_can_withdraw_pending_applications(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        $jobSeeker = $this->createJobSeeker();
        
        $application = JobApplication::create([
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($jobSeeker)->delete(route('applications.destroy', $application));
        
        $response->assertRedirect();
        $this->assertDatabaseMissing('job_applications', ['id' => $application->id]);
    }

    public function test_recruiters_can_view_applications_for_their_jobs(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        $jobSeeker = $this->createJobSeeker();
        
        JobApplication::create([
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($recruiter)->get(route('jobs.applications', $job));
        
        $response->assertOk();
        $response->assertViewIs('applications.index');
    }

    public function test_recruiters_cannot_view_applications_for_other_recruiters_jobs(): void
    {
        $recruiter1 = $this->createRecruiter();
        $recruiter2 = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter1->id]);

        $response = $this->actingAs($recruiter2)->get(route('jobs.applications', $job));
        
        $response->assertForbidden();
    }

    public function test_recruiters_can_update_application_status(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        $jobSeeker = $this->createJobSeeker();
        
        $application = JobApplication::create([
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($recruiter)->patch(route('applications.updateStatus', $application), [
            'status' => 'accepted',
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('job_applications', [
            'id' => $application->id,
            'status' => 'accepted',
        ]);
    }

    public function test_recruiters_cannot_update_status_for_other_recruiters_applications(): void
    {
        $recruiter1 = $this->createRecruiter();
        $recruiter2 = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter1->id]);
        $jobSeeker = $this->createJobSeeker();
        
        $application = JobApplication::create([
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($recruiter2)->patch(route('applications.updateStatus', $application), [
            'status' => 'accepted',
        ]);
        
        $response->assertForbidden();
    }
}
