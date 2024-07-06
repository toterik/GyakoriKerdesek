<?php

namespace App\Http\Controllers;
use App\Models\Answer;
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
}
