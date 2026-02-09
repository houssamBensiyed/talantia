<?php

namespace Tests\Feature;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class FriendshipTest extends TestCase
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

    protected function createUser(): User
    {
        $user = User::factory()->create();
        $user->assignRole('job_seeker');
        return $user;
    }

    public function test_users_can_view_friends_page(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('friends.index'));
        
        $response->assertOk();
        $response->assertViewIs('friends.index');
    }

    public function test_users_can_send_friend_requests(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        $response = $this->actingAs($user1)->post(route('friends.request', $user2));
        
        $response->assertRedirect();
        $this->assertDatabaseHas('friendships', [
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending',
        ]);
    }

    public function test_users_cannot_send_friend_request_to_themselves(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->post(route('friends.request', $user));
        
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_users_cannot_send_duplicate_friend_requests(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        // First request
        Friendship::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending',
        ]);

        // Try to send again
        $response = $this->actingAs($user1)->post(route('friends.request', $user2));
        
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_users_can_accept_friend_requests(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        $friendship = Friendship::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user2)->post(route('friends.accept', $friendship));
        
        $response->assertRedirect();
        $this->assertDatabaseHas('friendships', [
            'id' => $friendship->id,
            'status' => 'accepted',
        ]);
    }

    public function test_users_cannot_accept_requests_not_sent_to_them(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $user3 = $this->createUser();

        $friendship = Friendship::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending',
        ]);

        // User3 tries to accept a request meant for user2
        $response = $this->actingAs($user3)->post(route('friends.accept', $friendship));
        
        $response->assertForbidden();
    }

    public function test_users_can_reject_friend_requests(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        $friendship = Friendship::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user2)->post(route('friends.reject', $friendship));
        
        $response->assertRedirect();
        $this->assertDatabaseHas('friendships', [
            'id' => $friendship->id,
            'status' => 'rejected',
        ]);
    }

    public function test_users_can_cancel_sent_requests(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        $friendship = Friendship::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user1)->post(route('friends.cancel', $friendship));
        
        $response->assertRedirect();
        $this->assertDatabaseMissing('friendships', ['id' => $friendship->id]);
    }

    public function test_users_cannot_cancel_requests_they_did_not_send(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        $friendship = Friendship::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending',
        ]);

        // User2 tries to cancel a request they did not send
        $response = $this->actingAs($user2)->post(route('friends.cancel', $friendship));
        
        $response->assertForbidden();
    }

    public function test_users_can_remove_friends(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        Friendship::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($user1)->delete(route('friends.remove', $user2));
        
        $response->assertRedirect();
        $this->assertDatabaseMissing('friendships', [
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'accepted',
        ]);
    }

    public function test_sending_request_to_someone_who_already_sent_you_one_accepts_it(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();

        // User1 already sent a request to user2
        $friendship = Friendship::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'pending',
        ]);

        // User2 sends a request back - should automatically accept
        $response = $this->actingAs($user2)->post(route('friends.request', $user1));
        
        $response->assertRedirect();
        $response->assertSessionHas('status');
        $this->assertDatabaseHas('friendships', [
            'id' => $friendship->id,
            'status' => 'accepted',
        ]);
    }
}
