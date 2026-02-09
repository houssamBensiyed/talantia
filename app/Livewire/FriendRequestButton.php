<?php

namespace App\Livewire;

use App\Models\Friendship;
use App\Models\User;
use Livewire\Component;

class FriendRequestButton extends Component
{
    public User $user;
    public string $status = 'none'; // none, pending_sent, pending_received, friends

    public function mount(User $user)
    {
        $this->user = $user;
        $this->refreshStatus();
    }

    public function refreshStatus()
    {
        $currentUser = auth()->user();
        
        if (!$currentUser || $currentUser->id === $this->user->id) {
            $this->status = 'self';
            return;
        }

        if ($currentUser->isFriendWith($this->user)) {
            $this->status = 'friends';
        } elseif ($currentUser->hasPendingRequestTo($this->user)) {
            $this->status = 'pending_sent';
        } elseif ($currentUser->hasPendingRequestFrom($this->user)) {
            $this->status = 'pending_received';
        } else {
            $this->status = 'none';
        }
    }

    public function sendRequest()
    {
        $currentUser = auth()->user();

        if ($currentUser->id === $this->user->id) {
            return;
        }

        // Check if already friends or pending
        if ($this->status !== 'none') {
            return;
        }

        Friendship::create([
            'sender_id' => $currentUser->id,
            'receiver_id' => $this->user->id,
            'status' => 'pending',
        ]);

        $this->refreshStatus();
        $this->dispatch('friend-request-sent');
    }

    public function cancelRequest()
    {
        $currentUser = auth()->user();

        $friendship = Friendship::where('sender_id', $currentUser->id)
            ->where('receiver_id', $this->user->id)
            ->where('status', 'pending')
            ->first();

        if ($friendship) {
            $friendship->delete();
        }

        $this->refreshStatus();
    }

    public function acceptRequest()
    {
        $currentUser = auth()->user();

        $friendship = Friendship::where('sender_id', $this->user->id)
            ->where('receiver_id', $currentUser->id)
            ->where('status', 'pending')
            ->first();

        if ($friendship) {
            $friendship->accept();
        }

        $this->refreshStatus();
        $this->dispatch('friend-request-accepted');
    }

    public function rejectRequest()
    {
        $currentUser = auth()->user();

        $friendship = Friendship::where('sender_id', $this->user->id)
            ->where('receiver_id', $currentUser->id)
            ->where('status', 'pending')
            ->first();

        if ($friendship) {
            $friendship->reject();
        }

        $this->refreshStatus();
    }

    public function removeFriend()
    {
        $currentUser = auth()->user();
        $friendship = $currentUser->getFriendship($this->user);
        
        if ($friendship) {
            $friendship->delete();
        }

        $this->refreshStatus();
        $this->dispatch('friend-removed');
    }

    public function render()
    {
        return view('livewire.friend-request-button');
    }
}
