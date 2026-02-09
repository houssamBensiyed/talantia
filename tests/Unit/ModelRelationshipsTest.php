<?php

namespace Tests\Unit;

use App\Models\CandidateProfile;
use App\Models\Experience;
use App\Models\Formation;
use App\Models\Friendship;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ModelRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'recruiter']);
        Role::create(['name' => 'job_seeker']);
    }

    // ==========================================
    // USER MODEL TESTS
    // ==========================================

    public function test_user_has_candidate_profile_relationship(): void
    {
        $user = User::factory()->jobSeeker()->create();
        $profile = CandidateProfile::create([
            'user_id' => $user->id,
            'title' => 'Developer',
        ]);

        $this->assertTrue($user->candidateProfile->is($profile));
    }

    public function test_user_has_job_offers_relationship(): void
    {
        $user = User::factory()->recruiter()->create();
        $jobs = JobOffer::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertEquals(3, $user->jobOffers->count());
    }

    public function test_user_has_applications_relationship(): void
    {
        $user = User::factory()->jobSeeker()->create();
        $recruiter = User::factory()->recruiter()->create();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        
        JobApplication::create([
            'user_id' => $user->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $this->assertEquals(1, $user->applications->count());
    }

    public function test_user_is_recruiter_method(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        $jobSeeker = User::factory()->jobSeeker()->create();

        $this->assertTrue($recruiter->isRecruiter());
        $this->assertFalse($jobSeeker->isRecruiter());
    }

    public function test_user_is_job_seeker_method(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        $jobSeeker = User::factory()->jobSeeker()->create();

        $this->assertTrue($jobSeeker->isJobSeeker());
        $this->assertFalse($recruiter->isJobSeeker());
    }

    // ==========================================
    // CANDIDATE PROFILE MODEL TESTS
    // ==========================================

    public function test_candidate_profile_belongs_to_user(): void
    {
        $user = User::factory()->jobSeeker()->create();
        $profile = CandidateProfile::create([
            'user_id' => $user->id,
            'title' => 'Developer',
        ]);

        $this->assertTrue($profile->user->is($user));
    }

    public function test_candidate_profile_has_formations(): void
    {
        $user = User::factory()->jobSeeker()->create();
        $profile = CandidateProfile::create([
            'user_id' => $user->id,
            'title' => 'Developer',
        ]);
        
        Formation::create([
            'candidate_profile_id' => $profile->id,
            'diploma' => 'Master',
            'school' => 'University',
            'graduation_year' => 2020,
        ]);

        $this->assertEquals(1, $profile->formations->count());
    }

    public function test_candidate_profile_has_experiences(): void
    {
        $user = User::factory()->jobSeeker()->create();
        $profile = CandidateProfile::create([
            'user_id' => $user->id,
            'title' => 'Developer',
        ]);
        
        Experience::create([
            'candidate_profile_id' => $profile->id,
            'position' => 'Engineer',
            'company' => 'Company',
            'start_date' => '2020-01-01',
        ]);

        $this->assertEquals(1, $profile->experiences->count());
    }

    public function test_candidate_profile_has_skills(): void
    {
        $user = User::factory()->jobSeeker()->create();
        $profile = CandidateProfile::create([
            'user_id' => $user->id,
            'title' => 'Developer',
        ]);
        
        $skill = Skill::create(['name' => 'PHP']);
        $profile->skills()->attach($skill);

        $this->assertEquals(1, $profile->skills->count());
    }

    // ==========================================
    // JOB OFFER MODEL TESTS
    // ==========================================

    public function test_job_offer_belongs_to_recruiter(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);

        $this->assertTrue($job->recruiter->is($recruiter));
    }

    public function test_job_offer_has_applications(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        $jobSeeker = User::factory()->jobSeeker()->create();
        
        JobApplication::create([
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $this->assertEquals(1, $job->applications->count());
    }

    public function test_job_offer_open_scope(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        JobOffer::factory()->create(['user_id' => $recruiter->id, 'is_closed' => false]);
        JobOffer::factory()->create(['user_id' => $recruiter->id, 'is_closed' => true]);

        $this->assertEquals(1, JobOffer::open()->count());
    }

    public function test_job_offer_closed_scope(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        JobOffer::factory()->create(['user_id' => $recruiter->id, 'is_closed' => false]);
        JobOffer::factory()->create(['user_id' => $recruiter->id, 'is_closed' => true]);

        $this->assertEquals(1, JobOffer::closed()->count());
    }

    public function test_job_offer_close_and_reopen_methods(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id, 'is_closed' => false]);

        $job->close();
        $this->assertTrue($job->fresh()->is_closed);

        $job->reopen();
        $this->assertFalse($job->fresh()->is_closed);
    }

    public function test_job_offer_has_applicant_method(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        $jobSeeker1 = User::factory()->jobSeeker()->create();
        $jobSeeker2 = User::factory()->jobSeeker()->create();
        
        JobApplication::create([
            'user_id' => $jobSeeker1->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $this->assertTrue($job->hasApplicant($jobSeeker1));
        $this->assertFalse($job->hasApplicant($jobSeeker2));
    }

    // ==========================================
    // JOB APPLICATION MODEL TESTS
    // ==========================================

    public function test_job_application_belongs_to_applicant(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        $jobSeeker = User::factory()->jobSeeker()->create();
        
        $application = JobApplication::create([
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $this->assertTrue($application->applicant->is($jobSeeker));
    }

    public function test_job_application_belongs_to_job_offer(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        $jobSeeker = User::factory()->jobSeeker()->create();
        
        $application = JobApplication::create([
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $this->assertTrue($application->jobOffer->is($job));
    }

    public function test_job_application_status_methods(): void
    {
        $recruiter = User::factory()->recruiter()->create();
        $job = JobOffer::factory()->create(['user_id' => $recruiter->id]);
        $jobSeeker = User::factory()->jobSeeker()->create();
        
        $application = JobApplication::create([
            'user_id' => $jobSeeker->id,
            'job_offer_id' => $job->id,
            'status' => 'pending',
        ]);

        $this->assertTrue($application->isPending());
        
        $application->markAsReviewed();
        $this->assertTrue($application->fresh()->isReviewed());
        
        $application->accept();
        $this->assertTrue($application->fresh()->isAccepted());
    }

    // ==========================================
    // FRIENDSHIP MODEL TESTS
    // ==========================================

    public function test_friendship_belongs_to_sender_and_receiver(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $friendship = Friendship::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending',
        ]);

        $this->assertTrue($friendship->sender->is($user1));
        $this->assertTrue($friendship->receiver->is($user2));
    }

    public function test_friendship_status_methods(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $friendship = Friendship::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending',
        ]);

        $this->assertTrue($friendship->isPending());
        
        $friendship->accept();
        $this->assertTrue($friendship->fresh()->isAccepted());
        
        // Create new for reject test
        $friendship2 = Friendship::create([
            'sender_id' => $user2->id,
            'receiver_id' => $user1->id,
            'status' => 'pending',
        ]);
        
        $friendship2->reject();
        $this->assertTrue($friendship2->fresh()->isRejected());
    }
}
