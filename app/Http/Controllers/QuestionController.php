<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class QuestionController
{
    public function showQuestionsByTopic(Request $request)
    {
        $questions = Question::where('topic_id', $request->topicId)->get();
        return view('questions',compact('questions'));
    }

    public function newQuestionShow(Request $request)
    {
        $topics = Topic::all();
        return view('newQuestion', compact('topics'));
    }
    
    public function newQuestion(Request $request)
    {
        $request->validate([
            'topic' => 'required|string',
            'title' => 'required|string|max:20',
            'body' => 'required|string',
        ]);

        $topicName = $request->topic;
        $topicId = Topic::where('name', $topicName)->first()->id;
        $userId = auth()->user()->id;
        $title = $request->title;
        $body = $request->body;

        print($topicId);
        print($userId);
        print($title);
        print($body);

        $question = Question::create([
            'user_id' => $userId,
            'topic_id' => $topicId,
            'title' => $title,
            'body' => $body
        ]);
    
     
        dd($question);
        
        return view('newQuestionShow');
    }
}
