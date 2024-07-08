<?php

namespace App\Http\Controllers;
use App\Models\Topic;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

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
       

        return view('welcome', compact('topics'));
    }

    
    public function setTopicVisibility(Request $request,)
    {
        $id = $request->id;
        $topic = Topic::find($id);

        if ($topic) 
        {
       
            $topic->is_visible = !$topic->is_visible;
            $topic->save();

            return redirect()->back()->with('success', 'Topic visibility updated successfully!');
        }

        return redirect()->back()->with('error', 'Topic not found.');
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
}
