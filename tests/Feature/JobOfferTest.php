<?php

namespace Tests\Feature;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class JobOfferTest extends TestCase
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

    public function test_guests_cannot_view_job_listings(): void
    {
        $response = $this->get(route('jobs.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_job_listings(): void
    {
        $user = $this->createJobSeeker();
        
        $response = $this->actingAs($user)->get(route('jobs.index'));
        $response->assertOk();
        $response->assertViewIs('jobs.index');
    }

    public function test_authenticated_users_can_view_job_details(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        $jobSeeker = $this->createJobSeeker();

        $response = $this->actingAs($jobSeeker)->get(route('jobs.show', $job));
        $response->assertOk();
        $response->assertViewIs('jobs.show');
        $response->assertSee($job->title);
    }

    public function test_recruiters_can_access_create_job_form(): void
    {
        $recruiter = $this->createRecruiter();

        $response = $this->actingAs($recruiter)->get(route('jobs.create'));
        $response->assertOk();
        $response->assertViewIs('jobs.create');
    }

    public function test_job_seekers_cannot_access_create_job_form(): void
    {
        $jobSeeker = $this->createJobSeeker();

        $response = $this->actingAs($jobSeeker)->get(route('jobs.create'));
        $response->assertForbidden();
    }

    public function test_recruiters_can_create_job_offers(): void
    {
        Storage::fake('public');
        $recruiter = $this->createRecruiter();
        $image = UploadedFile::fake()->image('job.jpg');

        $response = $this->actingAs($recruiter)->post(route('jobs.store'), [
            'title' => 'Senior Laravel Developer',
            'description' => 'We are looking for an experienced Laravel developer.',
            'company' => 'TechCorp',
            'contract_type' => 'CDI',
            'image' => $image,
            'specialty' => 'Tech',
            'location' => 'Paris',
        ]);

        $response->assertRedirect(route('jobs.my'));
        $this->assertDatabaseHas('job_offers', [
            'title' => 'Senior Laravel Developer',
            'user_id' => $recruiter->id,
        ]);

        Storage::disk('public')->assertExists('job-images/' . $image->hashName());
    }

    public function test_job_seekers_cannot_create_job_offers(): void
    {
        Storage::fake('public');
        $jobSeeker = $this->createJobSeeker();
        $image = UploadedFile::fake()->image('job.jpg');

        $response = $this->actingAs($jobSeeker)->post(route('jobs.store'), [
            'title' => 'Senior Laravel Developer',
            'description' => 'We are looking for an experienced Laravel developer.',
            'company' => 'TechCorp',
            'contract_type' => 'CDI',
            'image' => $image,
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('job_offers', ['title' => 'Senior Laravel Developer']);
    }

    public function test_recruiters_can_edit_their_own_jobs(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);

        $response = $this->actingAs($recruiter)->get(route('jobs.edit', $job));
        $response->assertOk();
        $response->assertViewIs('jobs.edit');
    }

    public function test_recruiters_cannot_edit_other_recruiters_jobs(): void
    {
        $recruiter1 = $this->createRecruiter();
        $recruiter2 = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter1->id]);

        $response = $this->actingAs($recruiter2)->get(route('jobs.edit', $job));
        $response->assertForbidden();
    }

    public function test_recruiters_can_update_their_jobs(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);

        $response = $this->actingAs($recruiter)->put(route('jobs.update', $job), [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'company' => 'Updated Company',
            'contract_type' => 'CDD',
        ]);

        $response->assertRedirect(route('jobs.my'));
        $this->assertDatabaseHas('job_offers', [
            'id' => $job->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_recruiters_can_close_their_jobs(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id, 'is_closed' => false]);

        $response = $this->actingAs($recruiter)->post(route('jobs.close', $job));
        
        $response->assertRedirect();
        $this->assertDatabaseHas('job_offers', [
            'id' => $job->id,
            'is_closed' => true,
        ]);
    }

    public function test_recruiters_can_reopen_their_closed_jobs(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id, 'is_closed' => true]);

        $response = $this->actingAs($recruiter)->post(route('jobs.reopen', $job));
        
        $response->assertRedirect();
        $this->assertDatabaseHas('job_offers', [
            'id' => $job->id,
            'is_closed' => false,
        ]);
    }

    public function test_recruiters_can_delete_their_jobs(): void
    {
        $recruiter = $this->createRecruiter();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);

        $response = $this->actingAs($recruiter)->delete(route('jobs.destroy', $job));
        
        $response->assertRedirect(route('jobs.my'));
        $this->assertDatabaseMissing('job_offers', ['id' => $job->id]);
    }

    public function test_recruiters_can_view_their_job_offers(): void
    {
        $recruiter = $this->createRecruiter();
        JobOffer::factory()->count(3)->create(['user_id' => $recruiter->id]);

        $response = $this->actingAs($recruiter)->get(route('jobs.my'));
        
        $response->assertOk();
        $response->assertViewIs('jobs.my');
    }
}
