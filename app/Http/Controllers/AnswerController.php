<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * Controller for handling answer-related actions.
 */
class AnswerController extends Controller
{
    /**
     * Store a new answer in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAnswer(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'question_id' => 'required|integer',
            'body' => 'required|string|max:1000',
        ]);
    
        // Create a new answer in the database
        Answer::create([
            'user_id' => auth()->user()->id,
            'question_id' => $request->question_id,
            'body' => $request->body,
        ]);
    
        return redirect()->back()->with('success', 'Answer created successfully!');
    }
    
    /**
     * Delete an existing answer from the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAnswer(Request $request)
    {
        // Retrieve the answer ID from the request
        $answerId = $request->answerId;
        $answer = Answer::find($answerId);

        if ($answer) {
            // Delete the answer if it exists
            $answer->delete();
            return redirect()->back()->with('success', 'Answer deleted successfully!');
        }
        
        return redirect()->back()->with('error', 'Answer not found.');
    }
}
