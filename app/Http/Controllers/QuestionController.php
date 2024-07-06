<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Like;
use App\Models\Question;
use App\Models\Topic;
use App\Models\User;
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
    
    
        return view('questions.index');
    }

    public function show(Request $request)
    {
        $question = Question::where('id', $request->questionId)->first();
        $userName = User::find($question->user_id)->username;
        $answers = Answer::where('question_id', $request->questionId)->paginate(10);
       
        return view('questions.show', compact('question', 'answers','userName'));
    }
}