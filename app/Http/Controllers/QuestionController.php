<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Like;
use App\Models\Question;
use App\Models\Topic;
use App\Models\User;
use Auth;
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
        
        $topics = Topic::all()->where('is_visible','true');
        return view('questions.create', compact('topics'));
    }
    
    public function createNewQuestion(Request $request)
    {
        $request->validate([
            'topic' => 'required|string',
            'title' => 'required|string|max:30|unique:questions,title',
            'body' => 'required|string',
        ]);
        

        $topicName = $request->topic;
        $topicId = Topic::where('name', $topicName)->first()->id;
        $userId = auth()->user()->id;
        $title = $request->title;
        $body = $request->body;


         Question::create([
            'user_id' => $userId,
            'topic_id' => $topicId,
            'title' => $title,
            'body' => $body
        ]);
    
    
        return redirect()->back();
    }

    public function show(Request $request)
    {
        $question = Question::where('id', $request->questionId)->first();
        $userName = User::find($question->user_id)->username;
        $answers = Answer::where('question_id', $request->questionId)->with('user')->paginate(10);

        return view('questions.show', compact('question', 'answers','userName'));
    }

    public function deleteQuestion(Request $request)
    {
        $questionId = $request->questionId;
        $question = Question::find($questionId);
        $question->delete();
        $topicName = Topic::find($question->topic_id)->name;
        return redirect()->route('questions.index', ['topicName' => $topicName])->with('success', 'Question deleted successfully!');    
 
    }
    public function deleteFromProfile(Request $request)
    {
        $questionId = $request->questionId;
        Question::find($questionId)->delete();
        return redirect()->route('users.profile', ['userId' => Auth::user()->id]);              
    }
    
}