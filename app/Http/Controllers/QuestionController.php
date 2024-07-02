<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class QuestionController
{
    public function showQuestionsByTopic(Request $request)
    {
        $questions = Question::where('topic_id', $request->topicId)->get();
        print($questions);

        return view('questions',compact('questions'));
    }
}
