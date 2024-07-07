<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function createAnswer(Request $request)
    {
        Answer::create([
            'user_id' => auth()->user()->id,
            'question_id' => $request->question_id,
            'body' => $request->body
        ]);

        return redirect()->back()->with('success', 'Answer created successfully!');
    }

   
    public function deleteAnswer(Request $request)
    {
        $answerId = $request->answerId;
        $answer = Answer::find($answerId);

        if ($answer) {
            if (Auth::user()->is_admin)
             {
                $answer->delete();
                return redirect()->back()->with('success', 'Answer deleted successfully!');
            } else 
            {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }
        }
        return redirect()->back()->with('error', 'Answer not found.');
    }
}
