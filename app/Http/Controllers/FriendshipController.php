<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FriendshipController extends Controller
{
    /**
     * Display friends and friend requests.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        
        // Get all friends
        $friends = $user->friends()->get();
        
        // Get pending requests received
        $pendingRequests = $user->pendingFriendRequests()->with('sender')->get();
        
        // Get sent requests that are pending
        $sentRequests = $user->sentFriendRequests()
            ->where('status', 'pending')
            ->with('receiver')
            ->get();

        return view('friends.index', compact('friends', 'pendingRequests', 'sentRequests'));
    }

    /**
     * Send a friend request.
     */
    public function sendRequest(User $user): RedirectResponse
    {
        $currentUser = auth()->user();

        // Can't friend yourself
        if ($user->id === $currentUser->id) {
            return back()->with('error', 'Vous ne pouvez pas vous ajouter vous-même.');
        }

        // Check if already friends
        if ($currentUser->isFriendWith($user)) {
            return back()->with('error', 'Vous êtes déjà amis.');
        }

        // Check if request already sent
        if ($currentUser->hasPendingRequestTo($user)) {
            return back()->with('error', 'Demande d\'ami déjà envoyée.');
        }

        // Check if the other user has sent a request - if so, accept it
        if ($currentUser->hasPendingRequestFrom($user)) {
            $friendship = Friendship::where('sender_id', $user->id)
                ->where('receiver_id', $currentUser->id)
                ->first();
            $friendship->accept();
            return back()->with('status', 'Demande d\'ami acceptée!');
        }

        // Create new friend request
        Friendship::create([
            'sender_id' => $currentUser->id,
            'receiver_id' => $user->id,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Demande d\'ami envoyée!');
    }

    /**
     * Accept a friend request.
     */
    public function acceptRequest(Friendship $friendship): RedirectResponse
    {
        // Authorization check
        if ($friendship->receiver_id !== auth()->id()) {
            abort(403);
        }

        if (!$friendship->isPending()) {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $friendship->accept();

        return back()->with('status', 'Demande d\'ami acceptée!');
    }

    /**
     * Reject a friend request.
     */
    public function rejectRequest(Friendship $friendship): RedirectResponse
    {
        // Authorization check
        if ($friendship->receiver_id !== auth()->id()) {
            abort(403);
        }

        if (!$friendship->isPending()) {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $friendship->reject();

        return back()->with('status', 'Demande d\'ami refusée.');
    }

    /**
     * Remove a friend.
     */
    public function removeFriend(User $user): RedirectResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser->isFriendWith($user)) {
            return back()->with('error', 'Cette personne n\'est pas dans vos amis.');
        }

        // Find and delete the friendship
        $friendship = $currentUser->getFriendship($user);
        if ($friendship) {
            $friendship->delete();
        }

        return back()->with('status', 'Ami supprimé.');
    }

    /**
     * Cancel a pending friend request.
     */
    public function cancelRequest(Friendship $friendship): RedirectResponse
    {
        // Authorization check - only sender can cancel
        if ($friendship->sender_id !== auth()->id()) {
            abort(403);
        }

        if (!$friendship->isPending()) {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $friendship->delete();

        return back()->with('status', 'Demande d\'ami annulée.');
    }
}
