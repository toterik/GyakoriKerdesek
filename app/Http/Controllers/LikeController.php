<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Like;

/**
 * Controller for handling user votes (likes/dislikes) on answers.
 */
class LikeController
{
    /**
     * Handle the user's vote on an answer.
     *
     * This method validates the incoming vote, checks if the user has already voted
     * on the given answer, and updates or creates a vote accordingly.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vote(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'voteType' => 'required|integer|in:0,1',
        ]);

        // Get the authenticated user's ID
        $userId = Auth::user()->id;
        // Get the answer ID and vote type from the request
        $answerId = $request->answerId;
        $type = $request->voteType;

        // Find an existing like for the specified user and answer
        $like = Like::where('user_id', $userId)
                    ->where('answer_id', $answerId)
                    ->first();

        if ($like) {
            // If a like exists and the vote type is different, update the like
            if ($like->type != $type) {
                $like->update(['type' => $type]);
            }
        } else {
            // If no like exists, create a new one
            Like::create([
                'user_id' => $userId,
                'answer_id' => $answerId,
                'type' => $type,
            ]);
        }

        // Redirect back to the previous page
        return back();
    }
}
