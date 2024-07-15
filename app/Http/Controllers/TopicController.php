<?php

namespace App\Http\Controllers;
use App\Models\Topic;
use App\Models\Question;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TopicController extends Controller
{
    public function index()
    {
        if (auth()->user() == null || !auth()->user()->is_admin) 
        {
            $topics = Topic::where('is_visible', true)->orderBy('name', 'asc')->get();
        }
        else
        {
            $topics = Topic::orderBy('name', 'asc')->get();
        }
       
        $now = Carbon::now();
        $oneWeekAgo = $now->subWeek();
    
     
        $popularQuestions = Question::with('topic')
            ->select('questions.*')
            ->join('answers', 'questions.id', '=', 'answers.question_id')
            ->where('answers.created_at', '>=', $oneWeekAgo)
            ->groupBy('questions.id')
            ->orderByRaw('COUNT(answers.id) DESC')
            ->take(10)
            ->get();
        
        $randomUnansweredQuestions = Question::with('topic')
        ->whereDoesntHave('answers')
        ->inRandomOrder()
        ->limit(10)
        ->get();

        return view('welcome', compact('topics','popularQuestions','randomUnansweredQuestions'));
    }

    
    public function showEditTopicForm(Request $request)
    {
        $topic = Topic::find($request->id);
        return view('topics.edit', compact('topic'));
    }

    public function editTopic(Request $request)
    {
        $id = $request->id;
        $name =$request->topicName;
        $description = $request->description;
        $is_visible = $request->is_visible;

        Topic::where('id',$id)->update([
            'name'=>$name,
            'description' => $description,
            'is_visible'=> $is_visible]);

        return redirect()->route('index');
    }
    public function createTopic(Request $request)
    {
        $name =$request->topicName;
        $description = $request->description;
        $is_visible = $request->is_visible;
        Topic::create([
            'name'=>$name,
            'description' => $description,
            'is_visible'=> $is_visible]);

            return redirect()->route('index');
    }
    
    public function showCreateForm()
    {
        return view('topics.create');
    }

    public function deleteTopic(Request $request)
    {
        $id = $request->id;
        print($id);
        Topic::find($id)->delete();
        return redirect()->route('index');
    }
}
