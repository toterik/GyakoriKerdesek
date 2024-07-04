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
    $topic = Topic::where('name', $request->topicName)->first();
    $topicId = $topic ? $topic->id : null;

    $questions = Question::where('topic_id', $topicId)->get();
    $topicName = $request->topicName;
    return view('questions.index', compact('questions', 'topicName')); 
}


    public function showQuestionCreationForm(Request $request)
    {
        
        $topics = Topic::all();
        return view('questions.create', compact('topics'));
    }
    
    public function createNewQuestion(Request $request)
    {
        $request->validate([
            'topic' => 'required|string',
            'title' => 'required|string|max:30',
            'body' => 'required|string',
        ]);
        

        $topicName = $request->topic;
        $topicId = Topic::where('name', $topicName)->first()->id;
        $userId = auth()->user()->id;
        $title = $request->title;
        $body = $request->body;


        $question = Question::create([
            'user_id' => $userId,
            'topic_id' => $topicId,
            'title' => $title,
            'body' => $body
        ]);
    
     
        dd($question);
        
        return view('questions.index');
    }

    public function show(Request $request)
    {
        print(($request->questionId));
        print($request->topicName);
    }
}
