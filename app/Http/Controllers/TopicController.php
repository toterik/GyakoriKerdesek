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
